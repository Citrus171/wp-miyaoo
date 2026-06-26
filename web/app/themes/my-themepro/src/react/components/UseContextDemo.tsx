import { createContext, useContext, useState } from 'react'

type Theme = 'light' | 'dark'
const ThemeContext = createContext<{ theme: Theme; toggle: () => void }>({
  theme: 'light',
  toggle: () => {},
})

function Card() {
  const { theme } = useContext(ThemeContext)
  return (
    <div className={`rounded-xl p-5 border transition-colors duration-300 ${
      theme === 'dark'
        ? 'bg-[#09090b] border-[#27272a] text-white'
        : 'bg-white border-[#e4e4e7] text-[#09090b]'
    }`}>
      <p className="text-xs font-semibold mb-1 opacity-50">現在のテーマ</p>
      <p className="text-lg font-bold">{theme === 'dark' ? '🌙 Dark' : '☀️ Light'}</p>
      <p className={`text-xs mt-2 ${theme === 'dark' ? 'text-[#a1a1aa]' : 'text-[#71717a]'}`}>
        useContext で親からテーマを受け取っています
      </p>
    </div>
  )
}

export function UseContextDemo() {
  const [theme, setTheme] = useState<Theme>('light')

  return (
    <ThemeContext.Provider value={{ theme, toggle: () => setTheme(t => t === 'light' ? 'dark' : 'light') }}>
      <div className="space-y-3">
        <button
          onClick={() => setTheme(t => t === 'light' ? 'dark' : 'light')}
          className="btn-ghost text-sm"
        >
          {theme === 'light' ? '🌙 ダークに切り替え' : '☀️ ライトに切り替え'}
        </button>
        <Card />
      </div>
    </ThemeContext.Provider>
  )
}
