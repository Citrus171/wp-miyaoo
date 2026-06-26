import '../css/main.css'
import Alpine from 'alpinejs'

window.Alpine = Alpine
Alpine.start()

// スクロールフェードイン
const observer = new IntersectionObserver(
  (entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible')
        observer.unobserve(entry.target)
      }
    })
  },
  { threshold: 0.05, rootMargin: '0px 0px 100px 0px' }
)

document.querySelectorAll('.fade-up').forEach(el => observer.observe(el))

// TypeScript デモページ
if (document.getElementById('demo-generics')) {
  import('./typescript-demo').then(m => m.initTypescriptDemo())
}
