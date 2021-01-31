<template>
    <div class="flex w-full justify-between flex-no-wrap">
        <div class="flex items-center">
            <p class="bg-green-500 rounded-full p-3 text-white cursor-pointer" @click="$modal.show('info-box', steps[0])">
                <svg class="fill-current h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"/><path d="M6 3c3.49 0 6.383 2.554 6.913 5.895C14.088 7.724 15.71 7 17.5 7H22v2.5c0 3.59-2.91 6.5-6.5 6.5H13v5h-2v-8H9c-3.866 0-7-3.134-7-7V3h4zm14 6h-2.5c-2.485 0-4.5 2.015-4.5 4.5v.5h2.5c2.485 0 4.5-2.015 4.5-4.5V9zM6 5H4v1c0 2.761 2.239 5 5 5h2v-1c0-2.761-2.239-5-5-5z"/></svg>
            </p>
        </div>
        <div class="flex items-center w-full">
            <div class="flex-1 h-2 rounded-full mx-2" 
                :class="found ? 'bg-green-500' : 'bg-gray-200'"
            />
            <p 
                class="rounded-full p-3 cursor-pointer" 
                @click="$modal.show('info-box', steps[1])"
                :class="found ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-600 '"
            >
                 <svg class="fill-current h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M5 9a1 1 0 0 1 1 1 6.97 6.97 0 0 1 4.33 1.5h2.17c1.332 0 2.53.579 3.353 1.499L19 13a5 5 0 0 1 4.516 2.851C21.151 18.972 17.322 21 13 21c-2.79 0-5.15-.603-7.06-1.658A.998.998 0 0 1 5 20H2a1 1 0 0 1-1-1v-9a1 1 0 0 1 1-1h3zm1.001 3L6 17.021l.045.033C7.84 18.314 10.178 19 13 19c3.004 0 5.799-1.156 7.835-3.13l.133-.133-.12-.1a2.994 2.994 0 0 0-1.643-.63L19 15l-2.112-.001c.073.322.112.657.112 1.001v1H8v-2l6.79-.001-.034-.078a2.501 2.501 0 0 0-2.092-1.416L12.5 13.5H9.57A4.985 4.985 0 0 0 6.002 12zM4 11H3v7h1v-7zm9.646-7.425L14 3.93l.354-.354a2.5 2.5 0 1 1 3.535 3.536L14 11l-3.89-3.89a2.5 2.5 0 1 1 3.536-3.535zm-2.12 1.415a.5.5 0 0 0-.06.637l.058.069L14 8.17l2.476-2.474a.5.5 0 0 0 .058-.638l-.058-.07a.5.5 0 0 0-.638-.057l-.07.058-1.769 1.768-1.767-1.77-.068-.056a.5.5 0 0 0-.638.058z"/></svg>
            </p>
        </div>
        <div class="flex items-center w-full">
            <div class="flex-1 h-2 rounded-full mx-2" 
                :class="assigned ? 'bg-green-500' : 'bg-gray-200'"
            />
            <p 
                class="rounded-full p-3 cursor-pointer"  
                @click="$modal.show('info-box', steps[2])"
                :class="assigned ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-600 '"
            >
                <svg class="fill-current h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M3.161 4.469a6.5 6.5 0 0 1 8.84-.328 6.5 6.5 0 0 1 9.178 9.154l-7.765 7.79a2 2 0 0 1-2.719.102l-.11-.101-7.764-7.791a6.5 6.5 0 0 1 .34-8.826zm1.414 1.414a4.5 4.5 0 0 0-.146 6.21l.146.154L12 19.672l5.303-5.304-3.535-3.535-1.06 1.06a3 3 0 1 1-4.244-4.242l2.102-2.103a4.501 4.501 0 0 0-5.837.189l-.154.146zm8.486 2.828a1 1 0 0 1 1.414 0l4.242 4.242.708-.706a4.5 4.5 0 0 0-6.211-6.51l-.153.146-3.182 3.182a1 1 0 0 0-.078 1.327l.078.087a1 1 0 0 0 1.327.078l.087-.078 1.768-1.768z"/></svg>
            </p>
        </div>
        <div class="flex items-center w-full">
            <div class="flex-1 h-2 rounded-full mx-2" 
                :class="status === 'abgeschlossen' ? 'bg-green-500' : 'bg-gray-200'"
            />
            <p 
                class=" rounded-full p-3 cursor-pointer"  
                @click="$modal.show('info-box', steps[3])"
                :class="status === 'abgeschlossen' ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-600 '"
            >
                <svg class="fill-current h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-.997-4L6.76 11.757l1.414-1.414 2.829 2.829 5.656-5.657 1.415 1.414L11.003 16z"/></svg>
            </p>
        </div>
    </div>
</template>
<script>
export default {
    props:['status'],

    data(){
        return{
            steps: [
                {
                    text: 'Bedaft wurde erstellt.'
                },
                {
                    text: 'Mindestens ein Helfer hat sich gemeldet, und die Hilfe wurde angenommen.'
                },
                {
                    text: 'Es werden kine Helfer mehr gebraucht. Der Bedarf wurde als vermittelt markiert.'
                },
                {
                    text: 'Alle angenommen Hilfen wurden geleistet. Der Bedarf wurde als abgeschlossen markiert.',
                }
            ]
        }
    },

    computed:{
        found() {
            if (this.status === 'gefunden' || this.status === 'vermittelt' || this.status === 'abgeschlossen') {
                return true;
            }
            return false;
        },

        assigned() {
            if  (this.status === 'vermittelt' || this.status === 'abgeschlossen') {
                return true;
            }
            return false;
        }
    }

}
</script>