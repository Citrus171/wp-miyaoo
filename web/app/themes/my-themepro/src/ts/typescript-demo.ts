import {
  filterBy, groupBy, first,
  isPost, fetchPost,
  PostStore,
  type Post,
} from './examples'

// ─── デモ初期化 ──────────────────────────────────────────────
export function initTypescriptDemo(): void {
  initGenericsDemo()
  initTypeGuardDemo()
  initClassDemo()
  initFetchDemo()
}

// ─── 2. Generics デモ ─────────────────────────────────────────
function initGenericsDemo(): void {
  const posts: Post[] = [
    { id: 1, title: 'TypeScript入門',    category: 'tech',   published: true  },
    { id: 2, title: 'Tailwind CSS v4',   category: 'design', published: true  },
    { id: 3, title: '週末の過ごし方',    category: 'life',   published: false },
    { id: 4, title: 'Alpine.js Tips',    category: 'tech',   published: true  },
    { id: 5, title: 'デザインシステム',  category: 'design', published: true  },
  ]

  const techPosts  = filterBy(posts, p => p.category === 'tech')
  const published  = filterBy(posts, p => p.published)
  const grouped    = groupBy(posts, p => p.category)
  const topPost    = first(posts)

  const el = document.getElementById('demo-generics')
  if (!el) return

  el.innerHTML = `
    <div class="space-y-3 text-sm">
      <div class="flex items-center gap-2">
        <span class="text-xs text-[#a1a1aa] w-40 shrink-0">filterBy(tech)</span>
        <span class="text-[#09090b]">${techPosts.map(p => p.title).join(', ')}</span>
      </div>
      <div class="flex items-center gap-2">
        <span class="text-xs text-[#a1a1aa] w-40 shrink-0">filterBy(published)</span>
        <span class="text-[#09090b]">${published.length}件</span>
      </div>
      <div class="flex items-center gap-2">
        <span class="text-xs text-[#a1a1aa] w-40 shrink-0">groupBy(category)</span>
        <span class="text-[#09090b]">${Object.entries(grouped).map(([k, v]) => `${k}: ${v.length}件`).join(' / ')}</span>
      </div>
      <div class="flex items-center gap-2">
        <span class="text-xs text-[#a1a1aa] w-40 shrink-0">first()</span>
        <span class="text-[#09090b]">${topPost?.title ?? 'なし'}</span>
      </div>
    </div>
  `
}

// ─── 3. 型ガード デモ ─────────────────────────────────────────
function initTypeGuardDemo(): void {
  const btn = document.getElementById('btn-typeguard')
  const out = document.getElementById('demo-typeguard')
  if (!btn || !out) return

  btn.addEventListener('click', () => {
    const samples: unknown[] = [
      { id: 1, title: 'Hello', category: 'tech', published: true },
      'ただの文字列',
      42,
      null,
      { id: 2, title: 'World', category: 'design', published: false },
    ]

    const results = samples.map(s => ({
      value: JSON.stringify(s).slice(0, 30),
      isPost: isPost(s),
    }))

    out.innerHTML = results.map(r => `
      <div class="flex items-center gap-3">
        <span class="${r.isPost ? 'text-green-600' : 'text-[#a1a1aa]'} text-xs w-4">${r.isPost ? '✓' : '✕'}</span>
        <code class="text-xs text-[#52525b] font-mono">${r.value}</code>
      </div>
    `).join('')
  })
}

// ─── 6. Class デモ ────────────────────────────────────────────
function initClassDemo(): void {
  const store = new PostStore('My Blog')
  let nextId  = 1

  const input  = document.getElementById('class-input')   as HTMLInputElement | null
  const btnAdd = document.getElementById('class-btn-add')
  const btnClr = document.getElementById('class-btn-clear')
  const list   = document.getElementById('class-list')
  const count  = document.getElementById('class-count')
  const sname  = document.getElementById('class-name')

  if (!input || !btnAdd || !list || !count || !sname) return

  sname.textContent = store.name

  const render = (): void => {
    const posts = store.getAll()
    count.textContent = String(store.count())
    list.innerHTML = posts.length === 0
      ? '<p class="text-xs text-[#a1a1aa]">まだ投稿がありません</p>'
      : [...posts].map(p => `
          <div class="flex items-center justify-between gap-2 py-1.5 border-b border-[#f4f4f5] last:border-0">
            <span class="text-sm text-[#09090b]">${p.title}</span>
            <button data-id="${p.id}"
              class="text-xs text-[#a1a1aa] hover:text-red-500 transition-colors remove-btn">削除</button>
          </div>
        `).join('')

    list.querySelectorAll<HTMLButtonElement>('.remove-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        store.remove(Number(btn.dataset.id))
        render()
      })
    })
  }

  btnAdd.addEventListener('click', () => {
    const title = input.value.trim()
    if (!title) return
    store.add({ id: nextId++, title, category: 'tech', published: true })
    input.value = ''
    render()
  })

  input.addEventListener('keydown', e => {
    if (e.key === 'Enter') btnAdd.click()
  })

  btnClr?.addEventListener('click', () => {
    store.getAll().forEach(p => store.remove(p.id))
    render()
  })

  render()
}

// ─── 5. Fetch デモ ───────────────────────────────────────────
function initFetchDemo(): void {
  const btn = document.getElementById('btn-fetch')
  const out = document.getElementById('demo-fetch')
  if (!btn || !out) return

  btn.addEventListener('click', async () => {
    const id = Math.floor(Math.random() * 10) + 1
    out.innerHTML = '<span class="text-xs text-[#a1a1aa]">取得中...</span>'

    const result = await fetchPost(id)

    if (result.status === 'success') {
      out.innerHTML = `
        <div class="space-y-1">
          <p class="text-xs text-[#a1a1aa]">id: ${result.data.id}</p>
          <p class="text-sm font-medium text-[#09090b]">${result.data.title}</p>
          <p class="text-xs text-[#71717a] line-clamp-2">${result.data.body}</p>
        </div>
      `
    } else {
      out.innerHTML = `<span class="text-xs text-red-500">${result.message}</span>`
    }
  })
}
