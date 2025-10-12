<template>
  <BModal title="Import Data" v-model="modal" centered>
    <a href="/" class="btn btn-secondary"><i class="fa-solid fa-indent"></i> Download Format</a>
  </BModal>
</template>
<script setup>
import {useModel} from '@/helpers/hooks/bootstrap-components'
const modal = useModel(() => {}, 'import_modal')
</script>
