// ─── 1. Interface / Type Alias ────────────────────────────────
export interface Post {
  id: number
  title: string
  category: 'tech' | 'design' | 'life'
  published: boolean
}

export type Author = {
  name: string
  email: string
  role: 'admin' | 'editor' | 'viewer'
}

// ─── 2. Generics ──────────────────────────────────────────────
export function filterBy<T>(items: T[], predicate: (item: T) => boolean): T[] {
  return items.filter(predicate)
}

export function first<T>(items: T[]): T | undefined {
  return items[0]
}

export function groupBy<T, K extends string>(
  items: T[],
  key: (item: T) => K
): Record<K, T[]> {
  return items.reduce((acc, item) => {
    const k = key(item)
    acc[k] = acc[k] ?? []
    acc[k].push(item)
    return acc
  }, {} as Record<K, T[]>)
}

// ─── 3. 型ガード ──────────────────────────────────────────────
export function isPost(value: unknown): value is Post {
  return (
    typeof value === 'object' &&
    value !== null &&
    'id' in value &&
    'title' in value
  )
}

// Discriminated Union
type Success<T> = { status: 'success'; data: T }
type Failure     = { status: 'error';   message: string }
export type Result<T> = Success<T> | Failure

export function unwrap<T>(result: Result<T>): T {
  if (result.status === 'success') return result.data
  throw new Error(result.message)
}

// ─── 4. Utility Types ────────────────────────────────────────
export type PostDraft    = Partial<Post>
export type PostPreview  = Pick<Post, 'id' | 'title' | 'category'>
export type ImmutablePost = Readonly<Post>

// ─── 5. async/await + fetch ───────────────────────────────────
interface JsonPlaceholderPost {
  userId: number
  id: number
  title: string
  body: string
}

export async function fetchPost(id: number): Promise<Result<JsonPlaceholderPost>> {
  try {
    const res = await fetch(`https://jsonplaceholder.typicode.com/posts/${id}`)
    if (!res.ok) return { status: 'error', message: `HTTP ${res.status}` }
    const data = await res.json() as JsonPlaceholderPost
    return { status: 'success', data }
  } catch (e) {
    return { status: 'error', message: String(e) }
  }
}

// ─── 6. Class ────────────────────────────────────────────────
export class PostStore {
  readonly name: string
  private posts: Post[] = []

  constructor(name: string) {
    this.name = name
  }

  add(post: Post): void {
    this.posts.push(post)
  }

  remove(id: number): void {
    this.posts = this.posts.filter(p => p.id !== id)
  }

  getAll(): Readonly<Post[]> {
    return this.posts
  }

  getById(id: number): Post | undefined {
    return this.posts.find(p => p.id === id)
  }

  count(): number {
    return this.posts.length
  }
}
