import { InitApp } from '@/helpers/main'

import ExportModal from './import-export/ExportModal.vue'
import ImportModal from './import-export/ImportModal.vue'

const app = InitApp()

app.component('export-modal', ExportModal)
app.component('import-modal', ImportModal)

if(document.querySelector('[data-render="import-export"]')) {
  app.mount('[data-render="import-export"]');
}
