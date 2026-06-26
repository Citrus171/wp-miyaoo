import { useState, useEffect, useRef } from 'react'

export function UseEffectDemo() {
  const [seconds, setSeconds] = useState(0)
  const [running, setRunning] = useState(false)
  const [width, setWidth] = useState(0)
  const boxRef = useRef<HTMLDivElement>(null)

  // タイマー: running が変わるたびに effect が再実行される
  useEffect(() => {
    if (!running) return
    const id = setInterval(() => setSeconds(s => s + 1), 1000)
    return () => clearInterval(id) // クリーンアップ
  }, [running])

  // ResizeObserver: コンポーネントマウント時に1度だけ実行
  useEffect(() => {
    if (!boxRef.current) return
    const ro = new ResizeObserver(entries => {
      setWidth(Math.round(entries[0].contentRect.width))
    })
    ro.observe(boxRef.current)
    return () => ro.disconnect() // クリーンアップ
  }, [])

  const reset = () => {
    setRunning(false)
    setSeconds(0)
  }

  return (
    <div className="space-y-5">
      {/* タイマー */}
      <div>
        <p className="text-xs font-semibold text-[#09090b] mb-3">
          タイマー — cleanup で clearInterval
        </p>
        <div className="flex items-center gap-4">
          <span className="text-3xl font-semibold font-mono text-[#09090b] tabular-nums w-16">
            {seconds}s
          </span>
          <button onClick={() => setRunning(r => !r)} className="btn-primary">
            {running ? '停止' : '開始'}
          </button>
          <button
            onClick={reset}
            className="text-xs text-[#a1a1aa] hover:text-[#52525b] transition-colors"
          >
            リセット
          </button>
        </div>
      </div>

      {/* ResizeObserver */}
      <div>
        <p className="text-xs font-semibold text-[#09090b] mb-3">
          ResizeObserver — cleanup で disconnect
        </p>
        <div
          ref={boxRef}
          className="border border-dashed border-[#d4d4d8] rounded-xl p-4 resize-x overflow-auto min-w-[200px] max-w-full"
        >
          <p className="text-sm text-[#71717a]">← 右端をドラッグして幅を変えてみてください</p>
          <p className="text-xs text-[#a1a1aa] mt-1">
            現在の幅: <span className="font-mono text-[#09090b]">{width}px</span>
          </p>
        </div>
      </div>
    </div>
  )
}
