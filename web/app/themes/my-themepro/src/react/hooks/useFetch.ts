import { useState, useEffect } from 'react'

type FetchState<T> =
  | { status: 'idle' }
  | { status: 'loading' }
  | { status: 'success'; data: T }
  | { status: 'error'; message: string }

export function useFetch<T>(url: string | null) {
  const [state, setState] = useState<FetchState<T>>({ status: 'idle' })

  useEffect(() => {
    if (!url) return
    setState({ status: 'loading' })

    const controller = new AbortController()
    fetch(url, { signal: controller.signal })
      .then(res => {
        if (!res.ok) throw new Error(`HTTP ${res.status}`)
        return res.json() as Promise<T>
      })
      .then(data => setState({ status: 'success', data }))
      .catch(err => {
        if (err.name !== 'AbortError') {
          setState({ status: 'error', message: String(err) })
        }
      })

    return () => controller.abort()
  }, [url])

  return state
}
