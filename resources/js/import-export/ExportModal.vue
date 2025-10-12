<template>
  <BModal @hide="onHide" :title="$t('export.title')" v-model="modal" centered size="lg">
    <template v-slot:ok>
      <div class="d-grid d-md-block setting-footer">
        <!-- Bind the computed property to disable the button if the form is not valid -->
        <button
          v-if="isFormValid"
          @click="onSubmit"
          :disabled="IS_SUBMITED"
          class="btn btn-primary d-flex align-items-center gap-1"
          name="submit">
          <template v-if="IS_SUBMITED">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...
          </template>
          <template v-else>
            <i class="ph ph-download align-middle"></i>
            {{ $t('export.download') }}
          </template>
        </button>
      </div>
    </template>

    <!-- Other fields remain unchanged -->
    <div class="form-group">
      
        <p>{{ $t('export.lbl_select_file_type') }}</p>
        <BFormRadioGroup
          v-model="file_type"
          :options="buttonsOptions"
          button-variant="outline-primary"
          name="radios-btn-default"
          buttons
          class="flex-wrap"
        >
        </BFormRadioGroup>

    </div>
    <div class="form-group">
      <p>{{ $t('export.lbl_select_columns') }}</p>
      <BFormCheckboxGroup
        v-model="columns"
        :options="MODULE_COLUMNS"
        button-variant="outline-secondary"
        name="columns"
        stacked>
      </BFormCheckboxGroup>
    </div>
  </BModal>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useField, useForm } from 'vee-validate'
import { JSON_REQUEST_HEADER } from '@/helpers/utilities'
import flatPickr from 'vue-flatpickr-component';
import { useModel } from '@/helpers/hooks/bootstrap-components'
import * as yup from 'yup'
import * as moment from 'moment'

const props = defineProps({
  casttype: { type: String},
  exportUrl: { type: String },
  moduleName: { type: String },
  moduleColumnProp: { type: Array, default: () => [] },
})
const MODULE_COLUMNS = ref(props.moduleColumnProp)

const IS_SUBMITED = ref(false)

// Get the current date
const currentDate = moment();
// Calculate the date for 3 months ago
const threeMonthsAgo = currentDate.clone().subtract(3, 'months');
const config = ref({
    mode: "range",
    dateFormat: 'Y-m-d'
});

// Validations
const validationSchema = yup.object({
  file_type: yup.string()
    .required('File Type is a required field'),
})

const { handleSubmit, errors, resetForm } = useForm({
  validationSchema
})

const { value: file_type } = useField('file_type')
const { value: columns } = useField('columns')
const { value: casttype } = useField('casttype')

//  Reset Form
const setFormData = (data) => {
  resetForm({
    values: {
      file_type: data.file_type,
      columns: data.columns,
      casttype: data.casttype,
    }
  })
}

const defaultData = () => {
  return {
    file_type: 'csv',
    columns: MODULE_COLUMNS.value.map(({ value }) => value) || [],
    casttype: props.casttype ?? 'actor',
  }
}

// Computed property to check if all required fields are valid
const isFormValid = computed(() => {
  return file_type.value && columns.value.length > 0;
})

const modal = useModel(() => {}, 'export_modal')
const buttonsOptions = [
  {text: 'XLSX', value: 'xlsx'},
  {text: 'XLS', value: 'xls'},
  {text: 'ODS', value: 'ods'},
  {text: 'CSV', value: 'csv'},
  {text: 'PDF', value: 'pdf'},
  {text: 'HTML', value: 'html'},
]

const onSubmit = handleSubmit((values) => {
  IS_SUBMITED.value = true
  const queryParams = new URLSearchParams(Object.entries(values)).toString();
  const urlWithParams = `${props.exportUrl}?${queryParams}`;
  fetch(urlWithParams, {headers: JSON_REQUEST_HEADER}).then(async (res) => {
    if(res.status === 200) {
      const blob = await res.blob()
      const url = window.URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = `${props.moduleName}.${values.file_type}` // Set the filename for the download

      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
      window.URL.revokeObjectURL(url);
      IS_SUBMITED.value = false
    }
  }).catch(() => {
    IS_SUBMITED.value = false
  })
})

onMounted(() => {
  setFormData(defaultData())
})
const onHide = () => {
  setFormData(defaultData())
}
</script>
