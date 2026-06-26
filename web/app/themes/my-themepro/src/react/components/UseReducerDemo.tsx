import { useReducer } from 'react'

type State = { count: number; history: number[] }
type Action =
  | { type: 'increment'; by: number }
  | { type: 'decrement'; by: number }
  | { type: 'reset' }

function reducer(state: State, action: Action): State {
  switch (action.type) {
    case 'increment':
      return {
        count: state.count + action.by,
        history: [...state.history, state.count + action.by],
      }
    case 'decrement':
      return {
        count: state.count - action.by,
        history: [...state.history, state.count - action.by],
      }
    case 'reset':
      return { count: 0, history: [] }
  }
}

export function UseReducerDemo() {
  const [state, dispatch] = useReducer(reducer, { count: 0, history: [] })

  return (
    <div className="space-y-4">
      <div className="flex items-center gap-3">
        <span className="text-3xl font-semibold text-[#09090b] tabular-nums w-16 text-center">
          {state.count}
        </span>
        <div className="flex gap-2 flex-wrap">
          {[1, 5, 10].map(n => (
            <button
              key={n}
              onClick={() => dispatch({ type: 'increment', by: n })}
              className="btn-primary text-xs px-3 py-1.5"
            >
              +{n}
            </button>
          ))}
          {[1, 5, 10].map(n => (
            <button
              key={n}
              onClick={() => dispatch({ type: 'decrement', by: n })}
              className="btn-ghost text-xs px-3 py-1.5"
            >
              -{n}
            </button>
          ))}
          <button
            onClick={() => dispatch({ type: 'reset' })}
            className="text-xs text-[#a1a1aa] hover:text-[#52525b] transition-colors px-2"
          >
            リセット
          </button>
        </div>
      </div>
      {state.history.length > 0 && (
        <div className="flex gap-1.5 flex-wrap">
          {state.history.slice(-8).map((v, i) => (
            <span
              key={i}
              className="text-xs bg-[#f4f4f5] text-[#71717a] px-2 py-0.5 rounded-full font-mono"
            >
              {v}
            </span>
          ))}
        </div>
      )}
    </div>
  )
}
