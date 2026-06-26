import { useState, useMemo, useCallback } from 'react'

const ITEMS = Array.from({ length: 1000 }, (_, i) => ({
  id: i + 1,
  name: `Item ${i + 1}`,
  category: ['Tech', 'Design', 'Life'][i % 3],
  score: Math.floor(Math.random() * 100),
}))

type Item = typeof ITEMS[0]

interface RowProps {
  item: Item
  onSelect: (id: number) => void
}

function Row({ item, onSelect }: RowProps) {
  return (
    <div
      className="flex items-center justify-between py-1.5 border-b border-[#f4f4f5] last:border-0 cursor-pointer hover:bg-[#fafafa] px-2 rounded transition-colors"
      onClick={() => onSelect(item.id)}
    >
      <span className="text-sm text-[#09090b]">{item.name}</span>
      <div className="flex items-center gap-2">
        <span className="text-xs bg-[#f4f4f5] text-[#71717a] px-2 py-0.5 rounded-full">{item.category}</span>
        <span className="text-xs font-mono text-[#a1a1aa] w-6 text-right">{item.score}</span>
      </div>
    </div>
  )
}

export function UseMemoDemo() {
  const [query, setQuery] = useState('')
  const [selected, setSelected] = useState<number | null>(null)

  // useMemo: queryが変わった時だけフィルタリングを再計算
  const filtered = useMemo(() => {
    return ITEMS.filter(item =>
      item.name.toLowerCase().includes(query.toLowerCase()) ||
      item.category.toLowerCase().includes(query.toLowerCase())
    ).slice(0, 8)
  }, [query])

  // useCallback: 子コンポーネントへ渡す関数を再生成しない
  const handleSelect = useCallback((id: number) => {
    setSelected(id)
  }, [])

  return (
    <div className="space-y-3">
      <div className="flex gap-2 items-center">
        <input
          value={query}
          onChange={e => setQuery(e.target.value)}
          placeholder="検索（1000件から絞り込み）"
          className="flex-1 border border-[#e4e4e7] rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#a1a1aa] transition"
        />
        <span className="text-xs text-[#a1a1aa] shrink-0">{filtered.length}件</span>
      </div>
      <div className="border border-[#e4e4e7] rounded-xl overflow-hidden px-2 max-h-48 overflow-y-auto">
        {filtered.map(item => (
          <Row key={item.id} item={item} onSelect={handleSelect} />
        ))}
      </div>
      {selected && (
        <p className="text-xs text-[#71717a]">選択: Item {selected}</p>
      )}
    </div>
  )
}
