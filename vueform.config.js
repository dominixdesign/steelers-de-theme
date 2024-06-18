import de from '@vueform/vueform/locales/de'
import tailwind from '@vueform/vueform/dist/tailwind'
import { defineConfig } from '@vueform/vueform'

export default defineConfig({
  theme: tailwind,
  locales: { de },
  locale: 'de',
  size: 'lg',
  validateOn: 'change|step',
})