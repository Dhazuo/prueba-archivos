<template>
    <div v-if="!users" class="min-h-screen bg-gray-200 flex justify-center items-center">
        <div class="w-1/3 bg-white rounded-md shadow-md p-4 flex flex-col justify-center text-center">
            <div class="font-bold">IMPORTA TU ARCHIVO EXCEL</div>
            <div class="mt-6">
                <input id="excel" @change="files" ref="myFile" type="file">
            </div>
            <div class="mt-6">
                <button @click="upload" class="rounded-md bg-blue-500 hover:bg-blue-600 active:bg-blue-400 text-white px-4 py-2">Upload </button>
            </div>
        </div>
    </div>
    <div v-if="isProcessing && !users" class="bg-black fixed top-0 bg-opacity-75 w-full h-full flex justify-center items-center text-center">
        <span class="text-4xl font-bold text-white">
            {{ text }}
        </span>
    </div>
    <div v-else class="min-h-screen w-full p-4 bg-gray-200">
        <table class="w-full table-auto">
            <thead>
            <tr class="bg-white border-b-8 border-gray-400">
                <th>Nombre</th>
                <th>Numero de restaurante</th>
                <th>Nombre del líder</th>
                <th>Numero de miembros</th>
                <th>Custom id</th>
                <th>Status</th>
                <th>Direccion</th>
                <th>Nombre del archivo</th>
                <th>TOS Aceptados</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users" class="border-b border-gray-400 bg-white">
                <td class="p-4">
                    {{ user.name }}
                </td>
                <td class="p-4">
                    {{ user.restaurant_number }}
                </td>
                <td class="p-4">
                    {{ user.leader_name }}
                </td>
                <td class="p-4">
                    {{ user.members_number }}
                </td>
                <td class="p-4">
                    {{ user.custom_id }}
                </td>
                <td class="p-4">
                    {{ user.status }}
                </td>
                <td class="p-4">
                    {{ user.location }}
                </td>
                <td class="p-4">
                    {{ user.file_name }}
                </td>
                <td class="p-4">
                    {{ user.accepted_tos }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>


<script>
export default {
    name: "Participation",
    props: ['csrf'],
    data(){
        return{
            file: null,
            isProcessing: false,
            text: '',
            users: null
        }
    },
    watch: {
        'file': function () {
            let name = this.file[0].name
            let split = name.split('.')
            let position = split.length - 1
            let extension = split[position]

            if (extension != 'xlsx' && extension != 'csv') {
                alert('No es un archivo tipo Excel');
                let input = document.getElementById('excel')
                input.value = null
            }
        }
    },
    methods: {
        files(){
            this.file = this.$refs.myFile.files
        },
        upload(){
            if (!this.file) {
                alert('Agrega un archivo');
                return;
            }
            if (this.isProcessing) {
                return;
            }
            this.isProcessing = !this.isProcessing
            this.text = 'Estamos procesando los datos. Espera un momento...'
            console.log(this.csrf)
            axios.post(route('uploadExcel'), {
                file: this.file[0]
            }, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': this.csrf
                }
            }).then(response => {
                this.text = 'Datos cargados correctamente.'
                setTimeout(() => {
                    this.users = response.data.users
                }, 500)
            }).catch(error => {

            }).finally(() => this.isProcessing = false)

        }
    }
}
</script>

<style scoped>

</style>
