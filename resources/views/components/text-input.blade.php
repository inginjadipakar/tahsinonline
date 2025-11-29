@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 dark:border-white/10 bg-white dark:bg-islamic-navy-light/50 text-gray-900 dark:text-white focus:border-islamic-emerald dark:focus:border-islamic-gold focus:ring-islamic-emerald dark:focus:ring-islamic-gold rounded-xl shadow-sm transition-colors duration-300']) }}>
