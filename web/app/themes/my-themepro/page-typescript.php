<?php
/**
 * Template Name: TypeScript Examples
 */
get_header();
?>

<div class="pt-36 pb-32 max-w-5xl mx-auto px-6 space-y-24">

    <div class="fade-up">
        <p class="section-label">TypeScript</p>
        <h1 class="text-4xl font-bold tracking-tight text-[#09090b]">ベストプラクティス</h1>
        <p class="mt-3 text-[#71717a]">よく使うパターンの実装例とライブデモ</p>
    </div>

    <!-- ─── 1. Interface / Type Alias ─── -->
    <section class="fade-up">
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-1">1. Interface / Type Alias</h2>
        <p class="text-xs text-[#a1a1aa] mb-6">オブジェクトの形を定義する。<code class="font-mono bg-[#f4f4f5] px-1.5 py-0.5 rounded text-[#52525b]">interface</code> は拡張可能、<code class="font-mono bg-[#f4f4f5] px-1.5 py-0.5 rounded text-[#52525b]">type</code> はUnion/Intersectionに使う。</p>

        <pre class="bg-[#fafafa] border border-[#e4e4e7] rounded-xl p-5 text-xs font-mono text-[#52525b] overflow-x-auto leading-relaxed"><code><span class="text-[#a1a1aa]">// interface — extends で拡張できる</span>
<span class="text-blue-600">interface</span> Post {
  id:        <span class="text-green-700">number</span>
  title:     <span class="text-green-700">string</span>
  category:  <span class="text-orange-600">'tech'</span> | <span class="text-orange-600">'design'</span> | <span class="text-orange-600">'life'</span>  <span class="text-[#a1a1aa]">// Union Type</span>
  published: <span class="text-green-700">boolean</span>
}

<span class="text-[#a1a1aa]">// type alias — Utility Types と組み合わせやすい</span>
<span class="text-blue-600">type</span> Author = {
  name:  <span class="text-green-700">string</span>
  email: <span class="text-green-700">string</span>
  role:  <span class="text-orange-600">'admin'</span> | <span class="text-orange-600">'editor'</span> | <span class="text-orange-600">'viewer'</span>
}

<span class="text-[#a1a1aa]">// Utility Types</span>
<span class="text-blue-600">type</span> PostDraft    = <span class="text-purple-600">Partial</span>&lt;Post&gt;           <span class="text-[#a1a1aa]">// 全フィールドを optional に</span>
<span class="text-blue-600">type</span> PostPreview  = <span class="text-purple-600">Pick</span>&lt;Post, <span class="text-orange-600">'id'</span> | <span class="text-orange-600">'title'</span>&gt;  <span class="text-[#a1a1aa]">// 一部だけ抽出</span>
<span class="text-blue-600">type</span> ImmutablePost = <span class="text-purple-600">Readonly</span>&lt;Post&gt;        <span class="text-[#a1a1aa]">// 書き換え不可に</span></code></pre>
    </section>

    <!-- ─── 2. Generics ─── -->
    <section class="fade-up">
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-1">2. Generics</h2>
        <p class="text-xs text-[#a1a1aa] mb-6">型を引数として受け取る汎用関数。どんな型でも型安全に再利用できる。</p>

        <pre class="bg-[#fafafa] border border-[#e4e4e7] rounded-xl p-5 text-xs font-mono text-[#52525b] overflow-x-auto leading-relaxed mb-6"><code><span class="text-[#a1a1aa]">// &lt;T&gt; が型の引数</span>
<span class="text-blue-600">function</span> <span class="text-yellow-700">filterBy</span>&lt;T&gt;(items: T[], predicate: (item: T) =&gt; <span class="text-green-700">boolean</span>): T[] {
  <span class="text-blue-600">return</span> items.<span class="text-yellow-700">filter</span>(predicate)
}

<span class="text-blue-600">function</span> <span class="text-yellow-700">groupBy</span>&lt;T, K <span class="text-blue-600">extends</span> <span class="text-green-700">string</span>&gt;(
  items: T[],
  key: (item: T) =&gt; K
): <span class="text-purple-600">Record</span>&lt;K, T[]&gt; {
  <span class="text-blue-600">return</span> items.<span class="text-yellow-700">reduce</span>((acc, item) =&gt; {
    <span class="text-blue-600">const</span> k = <span class="text-yellow-700">key</span>(item)
    acc[k] = acc[k] ?? []
    acc[k].<span class="text-yellow-700">push</span>(item)
    <span class="text-blue-600">return</span> acc
  }, {} <span class="text-blue-600">as</span> <span class="text-purple-600">Record</span>&lt;K, T[]&gt;)
}</code></pre>

        <div id="demo-generics" class="border border-[#e4e4e7] rounded-xl p-5 bg-white min-h-[80px]">
            <span class="text-xs text-[#a1a1aa]">読み込み中...</span>
        </div>
    </section>

    <!-- ─── 3. 型ガード ─── -->
    <section class="fade-up">
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-1">3. 型ガード / Discriminated Union</h2>
        <p class="text-xs text-[#a1a1aa] mb-6"><code class="font-mono bg-[#f4f4f5] px-1.5 py-0.5 rounded text-[#52525b]">value is T</code> で型を絞り込む。<code class="font-mono bg-[#f4f4f5] px-1.5 py-0.5 rounded text-[#52525b]">unknown</code> を安全に扱える。</p>

        <pre class="bg-[#fafafa] border border-[#e4e4e7] rounded-xl p-5 text-xs font-mono text-[#52525b] overflow-x-auto leading-relaxed mb-6"><code><span class="text-[#a1a1aa]">// 型ガード関数 — 戻り値が "value is T" の形</span>
<span class="text-blue-600">function</span> <span class="text-yellow-700">isPost</span>(value: <span class="text-green-700">unknown</span>): value <span class="text-blue-600">is</span> Post {
  <span class="text-blue-600">return</span> (
    <span class="text-blue-600">typeof</span> value === <span class="text-orange-600">'object'</span> &amp;&amp; value !== <span class="text-blue-600">null</span> &amp;&amp;
    <span class="text-orange-600">'id'</span> <span class="text-blue-600">in</span> value &amp;&amp; <span class="text-orange-600">'title'</span> <span class="text-blue-600">in</span> value
  )
}

<span class="text-[#a1a1aa]">// Discriminated Union — status で分岐する</span>
<span class="text-blue-600">type</span> Result&lt;T&gt; =
  | { status: <span class="text-orange-600">'success'</span>; data: T }
  | { status: <span class="text-orange-600">'error'</span>;   message: <span class="text-green-700">string</span> }

<span class="text-blue-600">function</span> <span class="text-yellow-700">unwrap</span>&lt;T&gt;(result: Result&lt;T&gt;): T {
  <span class="text-blue-600">if</span> (result.status === <span class="text-orange-600">'success'</span>) <span class="text-blue-600">return</span> result.data
  <span class="text-blue-600">throw new</span> <span class="text-yellow-700">Error</span>(result.message)
}</code></pre>

        <div class="flex items-start gap-4">
            <button id="btn-typeguard" class="btn-ghost shrink-0">isPost() を実行</button>
            <div id="demo-typeguard" class="space-y-2 text-sm text-[#52525b]">
                <span class="text-xs text-[#a1a1aa]">ボタンを押すと各値を型ガードで検証します</span>
            </div>
        </div>
    </section>

    <!-- ─── 4. async/await + fetch ─── -->
    <section class="fade-up">
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-1">4. async / await + fetch</h2>
        <p class="text-xs text-[#a1a1aa] mb-6">API レスポンスに型を付ける。<code class="font-mono bg-[#f4f4f5] px-1.5 py-0.5 rounded text-[#52525b]">Result&lt;T&gt;</code> 型でエラーも型安全に扱う。</p>

        <pre class="bg-[#fafafa] border border-[#e4e4e7] rounded-xl p-5 text-xs font-mono text-[#52525b] overflow-x-auto leading-relaxed mb-6"><code><span class="text-blue-600">interface</span> ApiPost {
  userId: <span class="text-green-700">number</span>; id: <span class="text-green-700">number</span>; title: <span class="text-green-700">string</span>; body: <span class="text-green-700">string</span>
}

<span class="text-blue-600">async function</span> <span class="text-yellow-700">fetchPost</span>(id: <span class="text-green-700">number</span>): <span class="text-purple-600">Promise</span>&lt;Result&lt;ApiPost&gt;&gt; {
  <span class="text-blue-600">try</span> {
    <span class="text-blue-600">const</span> res  = <span class="text-blue-600">await</span> <span class="text-yellow-700">fetch</span>(<span class="text-orange-600">`https://jsonplaceholder.typicode.com/posts/${id}`</span>)
    <span class="text-blue-600">if</span> (!res.ok) <span class="text-blue-600">return</span> { status: <span class="text-orange-600">'error'</span>, message: <span class="text-orange-600">`HTTP ${res.status}`</span> }
    <span class="text-blue-600">const</span> data = <span class="text-blue-600">await</span> res.<span class="text-yellow-700">json</span>() <span class="text-blue-600">as</span> ApiPost
    <span class="text-blue-600">return</span> { status: <span class="text-orange-600">'success'</span>, data }
  } <span class="text-blue-600">catch</span> (e) {
    <span class="text-blue-600">return</span> { status: <span class="text-orange-600">'error'</span>, message: <span class="text-yellow-700">String</span>(e) }
  }
}</code></pre>

        <div class="flex items-start gap-4">
            <button id="btn-fetch" class="btn-primary shrink-0">API を叩く</button>
            <div id="demo-fetch" class="border border-[#e4e4e7] rounded-xl p-4 flex-1 min-h-[60px] bg-white">
                <span class="text-xs text-[#a1a1aa]">ランダムなIDで jsonplaceholder.typicode.com を取得します</span>
            </div>
        </div>
    </section>

    <!-- ─── 5. Class ─── -->
    <section class="fade-up">
        <h2 class="text-xs font-semibold tracking-widest uppercase text-[#a1a1aa] mb-1">5. Class</h2>
        <p class="text-xs text-[#a1a1aa] mb-6"><code class="font-mono bg-[#f4f4f5] px-1.5 py-0.5 rounded text-[#52525b]">private</code> で外部から隠蔽、<code class="font-mono bg-[#f4f4f5] px-1.5 py-0.5 rounded text-[#52525b]">readonly</code> で書き換え禁止。</p>

        <pre class="bg-[#fafafa] border border-[#e4e4e7] rounded-xl p-5 text-xs font-mono text-[#52525b] overflow-x-auto leading-relaxed mb-6"><code><span class="text-blue-600">class</span> PostStore {
  <span class="text-blue-600">readonly</span>  name:  <span class="text-green-700">string</span>          <span class="text-[#a1a1aa]">// 外から読める・書き換えは不可</span>
  <span class="text-blue-600">private</span>   posts: Post[] = []   <span class="text-[#a1a1aa]">// 外から見えない</span>

  <span class="text-yellow-700">constructor</span>(name: <span class="text-green-700">string</span>) { <span class="text-blue-600">this</span>.name = name }

  <span class="text-yellow-700">add</span>(post: Post): <span class="text-green-700">void</span>      { <span class="text-blue-600">this</span>.posts.<span class="text-yellow-700">push</span>(post) }
  <span class="text-yellow-700">remove</span>(id: <span class="text-green-700">number</span>): <span class="text-green-700">void</span> { <span class="text-blue-600">this</span>.posts = <span class="text-blue-600">this</span>.posts.<span class="text-yellow-700">filter</span>(p =&gt; p.id !== id) }
  <span class="text-yellow-700">getAll</span>(): <span class="text-purple-600">Readonly</span>&lt;Post[]&gt;  { <span class="text-blue-600">return this</span>.posts }
  <span class="text-yellow-700">count</span>():  <span class="text-green-700">number</span>           { <span class="text-blue-600">return this</span>.posts.length }
}</code></pre>

        <div class="border border-[#e4e4e7] rounded-xl p-5 bg-white">
            <p class="text-xs text-[#a1a1aa] mb-3">
                ストア名: <span id="class-name" class="font-mono text-[#09090b]"></span> &nbsp;|&nbsp;
                件数: <span id="class-count" class="font-mono text-[#09090b]">0</span>
            </p>
            <div class="flex gap-2 mb-4">
                <input id="class-input" type="text" placeholder="投稿タイトルを入力"
                    class="flex-1 border border-[#e4e4e7] rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#a1a1aa] transition">
                <button id="class-btn-add" class="btn-primary">追加</button>
                <button id="class-btn-clear" class="btn-ghost">全削除</button>
            </div>
            <div id="class-list" class="text-sm text-[#a1a1aa]">まだ投稿がありません</div>
        </div>
    </section>

</div>

<?php get_footer(); ?>
