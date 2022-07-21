<template>
    <div class="min-h-screen bg-gray-200 flex flex-col space-y-4 justify-center items-center">
        <div class="w-1/3 bg-white p-4">
            <div id="my-form" class="dropzone text-black flex justify-center"></div>
        </div>
        <button @click="doUpload" class="rounded-md bg-blue-500 hover:bg-blue-600 active:bg-blue-400 text-white px-4 py-2">Upload </button>
    </div>
</template>

<script>
import Dropzone from "dropzone";

export default {
    components: {
        Dropzone
    },
    props: ['uuid', 'csrf'],
    data() {
        return {
            isProcessing: false,
            dropzone: null,
            fileAdded: false,
            progress: 0,
            iconVideo: '<svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-gray-300 cursor-pointer" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <rect x="4" y="4" width="16" height="16" rx="2"></rect> <line x1="8" y1="4" x2="8" y2="20"></line> <line x1="16" y1="4" x2="16" y2="20"></line> <line x1="4" y1="8" x2="8" y2="8"></line> <line x1="4" y1="16" x2="8" y2="16"></line> <line x1="4" y1="12" x2="20" y2="12"></line> <line x1="16" y1="8" x2="20" y2="8"></line> <line x1="16" y1="16" x2="20" y2="16"></line> </svg>',
            iconVideoButton: '<svg xmlns="http://www.w3.org/2000/svg" className="icon icon-tabler icon-tabler-photo" width="24" height="24"\n' +
                '             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"\n' +
                '             stroke-linejoin="round">\n' +
                '            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>\n' +
                '            <line x1="15" y1="8" x2="15.01" y2="8"></line>\n' +
                '            <rect x="4" y="4" width="16" height="16" rx="3"></rect>\n' +
                '            <path d="M4 15l4 -4a3 5 0 0 1 3 0l5 5"></path>\n' +
                '            <path d="M14 14l1 -1a3 5 0 0 1 3 0l2 2"></path>\n' +
                '        </svg>'

        }

    },

    mounted() {
        this.setUp()
    },
    methods: {
        setUp() {

            let myDropzone = new Dropzone("div#my-form", {
                dictDefaultMessage: `<div><h1 class="font-bold text-2xl mx-auto uppercase">¡Sube tu imagen!</h1> <span class="uppercase text-sm">Arrastra y suelta archivos aquí</span> <div class="mt-6"><button class="text-sm mx-auto rounded-xl bg-gray-300 text-black font-black px-4 py-2 text-center transition duration-200 hover:bg-gray-300 focus:ring-2 focus:ring-yellow-400 flex items-center space-x-2"><span>${this.iconVideoButton}</span>  <span>SELECCIONAR IMAGEN</span></button></div> </div> `,
                dictFileTooBig: "El archivo es muy grande, el peso debe ser menor a 30 MB",
                dictInvalidFileType: "Tipo de archivo no permitido",
                dictCancelUpload: "Cancelar",
                dictCancelUploadConfirmation: "¿Deseas cancelar la subida del video?",
                dictRemoveFile: "Eliminar",
                dictMaxFilesExceeded: "No es posible subir mas imagenes",
                parallelUploads: 1,
                url: route('multimedia'),
                method: "POST",
                paramName: "multimedia", // The name that will be used to transfer the file
                maxFilesize: 3, // MB
                autoProcessQueue: false,
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                timeout: 0,
                maxFiles: 1,
                headers: {
                    'X-CSRF-TOKEN': this.csrf
                }
            });

            myDropzone.on("addedfile", file => {
                this.fileAdded = true;
            });
            myDropzone.on('sending', (data, xhr, formData) => {
                formData.append('uuid', this.uuid);
            });

            myDropzone.on('uploadprogress', (file, progress, bytesSent) => {
                this.progress = progress;
            });

            myDropzone.on("complete", (file, response) => {
                window.location = route('excel', this.uuid)
            })

            myDropzone.on('error', (file, message) => {
                alert('Ooops, hubo un error al cargar tu imagen');
            });

            this.dropzone = myDropzone;
        },
        doUpload() {
            if (!this.fileAdded) {
                return;
            }

            if (this.uploading) {
                return;
            }
            this.uploading = true;
            this.isProcessing = true;
            this.dropzone.processQueue();
        },
    }
}
</script>

<style>
@import "dropzone/dist/dropzone.css";

#upload {
    width: 100%;
}
.dropzone {
    font-family: 'Subway', sans-serif;
    border-style: dashed!important;
    border-width: 5px;
    border-color: rgba(215, 215, 215, 0.5);
}
.dz-default.dz-message button.dz-button{
    margin-left: auto!important;
    margin-right: auto!important;
}
.dz-error-message{
    top: 160px!important;
}
.dropzone.dz-clickable {
    cursor: pointer!important;
}
.dropzone .dz-preview.dz-image-preview {
    background: #fff;
    padding: 9px;
    border-radius: 25px;
}
.dropzone .dz-preview .dz-progress {
    opacity: 1;
    z-index: 1000;
    pointer-events: none;
    position: absolute;
    height: 20px;
    top: 70%;
    margin-top: -10px;
    left: 15%;
    right: 15%;
    border: 3pxsolidrgba(0,0,0,.8);
    background: rgba(0,0,0,.8);
    border-radius: 10px;
    overflow: hidden;
}

.swal2-title {
    color: #f0b700;
    text-align: center;
}
.swal2-text {
    color: black;
    text-align: center;
}

</style>
