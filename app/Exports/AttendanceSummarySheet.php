<?php

namespace App\Exports;

use App\Models\TeachingAttendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AttendanceSummarySheet implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithColumnWidths
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = TeachingAttendance::with(['teacher', 'lesson.tahsinClass', 'students'])
            ->orderBy('attendance_date', 'desc')
            ->orderBy('created_at', 'desc');

        // Apply filters
        if (!empty($this->filters['teacher_id'])) {
            $query->where('teacher_id', $this->filters['teacher_id']);
        }
        if (!empty($this->filters['class_id'])) {
            $query->whereHas('lesson.tahsinClass', function($q) {
                $q->where('id', $this->filters['class_id']);
            });
        }
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        if (!empty($this->filters['date_from'])) {
            $query->where('attendance_date', '>=', $this->filters['date_from']);
        }
        if (!empty($this->filters['date_to'])) {
            $query->where('attendance_date', '<=', $this->filters['date_to']);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            ['LAPORAN ABSENSI MENGAJAR'],
            ['TAHSIN ONLINE'],
            ['Periode: ' . now()->format('d F Y')],
            [],
            ['No', 'Tanggal', 'Pengajar', 'Kelas', 'Pertemuan', 'Jumlah Murid', 'Jam Mulai', 'Jam Selesai', 'Durasi (jam)', 'Status', 'Catatan Admin']
        ];
    }

    public function map($attendance): array
    {
        static $no = 1;
        return [
            $no++,
            $attendance->attendance_date->format('d/m/Y'),
            $attendance->teacher->name,
            $attendance->lesson->tahsinClass->name,
            'P' . $attendance->lesson->order,
            $attendance->students->count(),
            \Carbon\Carbon::parse($attendance->start_time)->format('H:i'),
            \Carbon\Carbon::parse($attendance->end_time)->format('H:i'),
            $attendance->duration,
            ucfirst($attendance->status),
            $attendance->admin_notes ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header styling
        $sheet->mergeCells('A1:K1');
        $sheet->mergeCells('A2:K2');
        $sheet->mergeCells('A3:K3');
        
        $sheet->getStyle('A1:A3')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Table headers
        $sheet->getStyle('A5:K5')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '047857'], // Emerald
            ],
            'font' => ['color' => ['rgb' => 'FFFFFF']],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ]);

        // Auto-filter
        $sheet->setAutoFilter('A5:K5');

        return [];
    }

    public function title(): string
    {
        return 'Ringkasan Absensi';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 12,
            'C' => 20,
            'D' => 20,
            'E' => 10,
            'F' => 12,
            'G' => 10,
            'H' => 10,
            'I' => 12,
            'J' => 10,
            'K' => 30,
        ];
    }
}
