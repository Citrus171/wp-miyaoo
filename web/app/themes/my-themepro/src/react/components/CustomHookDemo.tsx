import { useState } from 'react'
import { useFetch } from '../hooks/useFetch'
import { useLocalStorage } from '../hooks/useLocalStorage'

interface Post {
  id: number
  title: string
  body: string
}

export function CustomHookDemo() {
  const [postId, setPostId] = useState<number | null>(null)
  const [note, setNote] = useLocalStorage('react-demo-note', '')

  const url = postId ? `https://jsonplaceholder.typicode.com/posts/${postId}` : null
  const state = useFetch<Post>(url)

  return (
    <div className="space-y-6">

      {/* useFetch */}
      <div>
        <p className="text-xs font-semibold text-[#09090b] mb-2">useFetch — データ取得 + AbortController</p>
        <div className="flex gap-2 mb-3 flex-wrap">
          {[1, 2, 3, 4, 5].map(id => (
            <button key={id} onClick={() => setPostId(id)}
              className={`text-xs px-3 py-1.5 rounded-full border transition-colors ${
                postId === id
                  ? 'bg-[#09090b] text-white border-[#09090b]'
                  : 'border-[#e4e4e7] text-[#52525b] hover:border-[#a1a1aa]'
              }`}>
              Post {id}
            </button>
          ))}
        </div>
        <div className="border border-[#e4e4e7] rounded-xl p-4 min-h-[60px] bg-[#fafafa] text-sm">
          {state.status === 'idle'    && <span className="text-[#a1a1aa]">ボタンを選択してください</span>}
          {state.status === 'loading' && <span className="text-[#a1a1aa]">取得中...</span>}
          {state.status === 'error'   && <span className="text-red-500">{state.message}</span>}
          {state.status === 'success' && (
            <div>
              <p className="font-medium text-[#09090b] mb-1">{state.data.title}</p>
              <p className="text-xs text-[#71717a] line-clamp-2">{state.data.body}</p>
            </div>
          )}
        </div>
      </div>

      {/* useLocalStorage */}
      <div>
        <p className="text-xs font-semibold text-[#09090b] mb-2">useLocalStorage — リロードしても保持</p>
        <textarea
          value={note}
          onChange={e => setNote(e.target.value)}
          placeholder="ここに書いた内容はlocalStorageに保存されます..."
          rows={3}
          className="w-full border border-[#e4e4e7] rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#a1a1aa] transition resize-none"
        />
        <p className="text-xs text-[#a1a1aa] mt-1">Key: <code className="font-mono">react-demo-note</code></p>
      </div>

    </div>
  )
}
