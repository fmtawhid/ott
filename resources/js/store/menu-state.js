import {ref} from 'vue'
import { defineStore } from 'pinia';
import { confirmSwal } from '@/helpers/utilities'
import { useRequest } from '@/helpers/hooks/useCrudOpration'
import { DELETE_URL } from '@/vue/constants/menu_builder'

export const useMenu = defineStore('menu', () => {
    const editId = ref(null)

    const deleteId = ref(null)

    const { deleteRequest } = useRequest()

    function setEditCurrentMenuId(value) {
        editId.value = value
    }

    function deleteMenu(value, message) {
        deleteId.value = value
        confirmSwal({ title: message }).then((result) => {
            if (!result.isConfirmed) return
            deleteRequest({ url: DELETE_URL, id: value }).then((res) => {
                if (res.status) {
                    deleteId.value = null
                    Swal.fire({
                        title: 'Deleted',
                        text: res.message,
                        icon: 'success',
                        showClass: {
                            popup: 'animate__animated animate__zoomIn'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__zoomOut'
                        }
                    }).then(() => {
                        window.location.reload()
                    })
                }
            })
        })
    }

    return { editId, deleteId, setEditCurrentMenuId, deleteMenu }
})