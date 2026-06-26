import { createRoot } from 'react-dom/client'
import { UseStateDemo } from './components/UseStateDemo'
import { UseReducerDemo } from './components/UseReducerDemo'
import { UseContextDemo } from './components/UseContextDemo'
import { UseMemoDemo } from './components/UseMemoDemo'
import { UseEffectDemo } from './components/UseEffectDemo'
import { CustomHookDemo } from './components/CustomHookDemo'

const mounts: Record<string, React.ReactNode> = {
  'react-usestate': <UseStateDemo />,
  'react-usereducer': <UseReducerDemo />,
  'react-usecontext': <UseContextDemo />,
  'react-usememo': <UseMemoDemo />,
  'react-useeffect': <UseEffectDemo />,
  'react-customhook': <CustomHookDemo />,
}

Object.entries(mounts).forEach(([id, component]) => {
  const el = document.getElementById(id)
  if (el) createRoot(el).render(component)
})
