<?php
/**
 * Template Name: React Examples
 */
get_header();

function code_block(string $code): void {
    $map = [
        // キーワード
        '/\b(import|export|from|const|let|function|return|switch|case|type|interface|extends|implements|new|class|if|throw|default)\b/' =>
            '<span class="text-blue-600">$1</span>',
        // 型
        '/\b(string|number|boolean|void|null|undefined|Promise|Record|Readonly)\b/' =>
            '<span class="text-green-700">$1</span>',
        // 文字列
        "/'([^'\\n]*)'/s" => "'<span class=\"text-orange-600\">$1</span>'",
        '/`([^`]*)`/s'    => '`<span class="text-orange-600">$1</span>`',
        // 関数・フック
        '/\b(useState|useEffect|useReducer|useContext|useMemo|useCallback|useRef|createContext|createRoot|useLocalStorage|useFetch)\b/' =>
            '<span class="text-yellow-700">$1</span>',
        // コメント
        '/(\/\/[^\n]*)/'  => '<span class="text-[#a1a1aa]">$1</span>',
    ];
    $escaped = htmlspecialchars($code, ENT_QUOTES);
    $highlighted = preg_replace(array_keys($map), array_values($map), $escaped);
    echo '<pre class="bg-[#fafafa] border border-[#e4e4e7] rounded-xl p-5 text-xs font-mono text-[#52525b] overflow-x-auto leading-relaxed"><code>' . $highlighted . '</code></pre>';
}
?>

<div class="pt-36 pb-32 max-w-5xl mx-auto px-6 space-y-24">

    <div>
        <p class="section-label">React</p>
        <h1 class="text-4xl font-bold tracking-tight text-[#09090b]">ベストプラクティス</h1>
        <p class="mt-3 text-[#71717a]">よく使うフックとカスタムフックの実装例</p>
    </div>

    <!-- ─── 1. useState ─── -->
    <section>
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-1">1. useState</h2>
        <p class="text-xs text-[#a1a1aa] mb-5">コンポーネントにローカルな状態を持たせる。変更があると再レンダリングされる。</p>
        <?php code_block(<<<'CODE'
const [tasks, setTasks] = useState<Task[]>([])
const [input, setInput] = useState('')

// イミュータブルに更新（元の配列を変更しない）
const add    = () => setTasks(prev => [...prev, { id: nextId++, text: input, done: false }])
const toggle = (id: number) =>
  setTasks(prev => prev.map(t => t.id === id ? { ...t, done: !t.done } : t))
const remove = (id: number) =>
  setTasks(prev => prev.filter(t => t.id !== id))
CODE); ?>
        <div class="mt-5 border border-[#e4e4e7] rounded-xl p-5 bg-white">
            <div id="react-usestate"></div>
        </div>
    </section>

    <!-- ─── 2. useReducer ─── -->
    <section>
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-1">2. useReducer</h2>
        <p class="text-xs text-[#a1a1aa] mb-5">複雑な状態遷移を reducer 関数で管理。ActionのUnion型で型安全。</p>
        <?php code_block(<<<'CODE'
type Action =
  | { type: 'increment'; by: number }
  | { type: 'decrement'; by: number }
  | { type: 'reset' }

function reducer(state: State, action: Action): State {
  switch (action.type) {
    case 'increment': return { count: state.count + action.by, ... }
    case 'decrement': return { count: state.count - action.by, ... }
    case 'reset':     return { count: 0, history: [] }
  }
}

const [state, dispatch] = useReducer(reducer, { count: 0, history: [] })
dispatch({ type: 'increment', by: 5 })
CODE); ?>
        <div class="mt-5 border border-[#e4e4e7] rounded-xl p-5 bg-white">
            <div id="react-usereducer"></div>
        </div>
    </section>

    <!-- ─── 3. useContext ─── -->
    <section>
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-1">3. useContext</h2>
        <p class="text-xs text-[#a1a1aa] mb-5">props を渡さずに深い階層へ値を届ける。テーマ・認証情報など。</p>
        <?php code_block(<<<'CODE'
const ThemeContext = createContext<{ theme: Theme; toggle: () => void }>({
  theme: 'light',
  toggle: () => {},
})

// 子コンポーネントで受け取る
function Card() {
  const { theme } = useContext(ThemeContext)
  return <div className={theme === 'dark' ? 'bg-black text-white' : 'bg-white'}>...</div>
}

// Provider で包む
<ThemeContext.Provider value={{ theme, toggle }}>
  <Card />
</ThemeContext.Provider>
CODE); ?>
        <div class="mt-5 border border-[#e4e4e7] rounded-xl p-5 bg-white">
            <div id="react-usecontext"></div>
        </div>
    </section>

    <!-- ─── 4. useMemo / useCallback ─── -->
    <section>
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-1">4. useMemo / useCallback</h2>
        <p class="text-xs text-[#a1a1aa] mb-5">依存値が変わった時だけ再計算・再生成。不要なレンダリングを防ぐ。</p>
        <?php code_block(<<<'CODE'
// useMemo: 重い計算をキャッシュ。queryが変わった時だけ再実行
const filtered = useMemo(() =>
  ITEMS.filter(item => item.name.includes(query))
, [query])

// useCallback: 子へ渡す関数の再生成を防ぐ（依存なし→常に同じ参照）
const handleSelect = useCallback((id: number) => {
  setSelected(id)
}, [])
CODE); ?>
        <div class="mt-5 border border-[#e4e4e7] rounded-xl p-5 bg-white">
            <div id="react-usememo"></div>
        </div>
    </section>

    <!-- ─── 5. useEffect ─── -->
    <section>
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-1">5. useEffect</h2>
        <p class="text-xs text-[#a1a1aa] mb-5">副作用の実行。タイマー・イベント購読など必ずクリーンアップ関数を返す。</p>
        <?php code_block(<<<'CODE'
// タイマー: running が変わるたびに再実行
useEffect(() => {
  if (!running) return
  const id = setInterval(() => setSeconds(s => s + 1), 1000)
  return () => clearInterval(id)  // クリーンアップ（メモリリーク防止）
}, [running])

// マウント時1回だけ: []を依存配列に
useEffect(() => {
  const ro = new ResizeObserver(entries => { setWidth(entries[0].contentRect.width) })
  ro.observe(boxRef.current!)
  return () => ro.disconnect()  // クリーンアップ
}, [])
CODE); ?>
        <div class="mt-5 border border-[#e4e4e7] rounded-xl p-5 bg-white">
            <div id="react-useeffect"></div>
        </div>
    </section>

    <!-- ─── 6. カスタムフック ─── -->
    <section>
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-1">6. カスタムフック</h2>
        <p class="text-xs text-[#a1a1aa] mb-5">ロジックを <code class="font-mono bg-[#f4f4f5] px-1.5 py-0.5 rounded">use〇〇</code> として切り出して再利用する。</p>
        <?php code_block(<<<'CODE'
// useFetch: fetch + AbortController + Result型
function useFetch<T>(url: string | null) {
  const [state, setState] = useState<FetchState<T>>({ status: 'idle' })
  useEffect(() => {
    if (!url) return
    const controller = new AbortController()
    fetch(url, { signal: controller.signal })
      .then(res => res.json() as Promise<T>)
      .then(data => setState({ status: 'success', data }))
      .catch(err => setState({ status: 'error', message: String(err) }))
    return () => controller.abort()
  }, [url])
  return state
}

// useLocalStorage: localStorage を useState のように使う
function useLocalStorage<T>(key: string, initialValue: T) {
  const [value, setValue] = useState<T>(() =>
    JSON.parse(localStorage.getItem(key) ?? 'null') ?? initialValue
  )
  const set = (v: T) => { setValue(v); localStorage.setItem(key, JSON.stringify(v)) }
  return [value, set] as const
}
CODE); ?>
        <div class="mt-5 border border-[#e4e4e7] rounded-xl p-5 bg-white">
            <div id="react-customhook"></div>
        </div>
    </section>

</div>

<?php get_footer(); ?>
