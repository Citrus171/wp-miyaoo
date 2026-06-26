import { useState } from 'react'

interface Task {
  id: number
  text: string
  done: boolean
}

export function UseStateDemo() {
  const [tasks, setTasks] = useState<Task[]>([
    { id: 1, text: 'Reactを学ぶ', done: true },
    { id: 2, text: 'TypeScriptを学ぶ', done: false },
  ])
  const [input, setInput] = useState('')
  let nextId = tasks.length + 1

  const add = () => {
    if (!input.trim()) return
    setTasks(prev => [...prev, { id: nextId++, text: input.trim(), done: false }])
    setInput('')
  }

  const toggle = (id: number) =>
    setTasks(prev => prev.map(t => (t.id === id ? { ...t, done: !t.done } : t)))

  const remove = (id: number) => setTasks(prev => prev.filter(t => t.id !== id))

  return (
    <div className="space-y-3">
      <div className="flex gap-2">
        <input
          value={input}
          onChange={e => setInput(e.target.value)}
          onKeyDown={e => e.key === 'Enter' && add()}
          placeholder="タスクを追加"
          className="flex-1 border border-[#e4e4e7] rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#a1a1aa] transition"
        />
        <button onClick={add} className="btn-primary">
          追加
        </button>
      </div>
      <ul className="space-y-1">
        {tasks.map(task => (
          <li
            key={task.id}
            className="flex items-center gap-3 py-1.5 border-b border-[#f4f4f5] last:border-0"
          >
            <input
              type="checkbox"
              checked={task.done}
              onChange={() => toggle(task.id)}
              className="accent-[#09090b]"
            />
            <span
              className={`flex-1 text-sm ${task.done ? 'line-through text-[#a1a1aa]' : 'text-[#09090b]'}`}
            >
              {task.text}
            </span>
            <button
              onClick={() => remove(task.id)}
              className="text-xs text-[#d4d4d8] hover:text-red-400 transition-colors"
            >
              ✕
            </button>
          </li>
        ))}
      </ul>
      <p className="text-xs text-[#a1a1aa]">
        {tasks.filter(t => t.done).length} / {tasks.length} 完了
      </p>
    </div>
  )
}
