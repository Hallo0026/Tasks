<template>
    <aside id="group-sidebar" class="">

        <!--<div class="d-flex">
            <button id="toggle-btn" type="button" @click="toggleSidebar">
                <ViewGridOutlineIcon :size="30"/>
            </button>
            <div class="group-sidebar-logo">
                <a href="#" class="text-black">
                    Vinicius
                </a>
            </div>
        </div>-->

        <li class="sidebar-item">

            <span id="close-group-sidebar-icon" class="close-group-sidebar-icon hide" @click="toggleSidebar()">
                <CloseCircleOutline :size="26"/>
            </span>

            <a href="#" class="group-sidebar-link">

                <input type="text" class="input-text-group-sidebar group-title" v-model="groupTitle">

                <div v-if="groupDescription">
                    <input type="text" class="input-text-group-sidebar group-description" v-model="groupDescription">
                </div>
                <div v-else>
                    <input type="text" class="input-text-group-sidebar group-description" v-model="groupDescription" placeholder="Adicione um comentário">
                </div>

                <span class="titulo-item-sidebar"></span>

            </a>
        </li>

        <div class="group-sidebar-footer"></div>

    </aside>
</template>

<script>
import PlusCircleOutlineIcon from 'vue-material-design-icons/PlusCircleOutline.vue';
import ViewGridOutlineIcon from 'vue-material-design-icons/ViewGridOutline.vue';
import CloseCircleOutline from 'vue-material-design-icons/CloseCircleOutline.vue';
import { mapState } from 'vuex';

export default {
    name: 'group-sidebarComponent',
    props: ['appName', 'userId'],
    components: {
        PlusCircleOutlineIcon,
        ViewGridOutlineIcon,
        CloseCircleOutline
    },
    computed: {

        ...mapState('groupDetails', {
            groupDetails: state => state.groupDetails
        }),

        groupTitle() {
            return this.groupDetails ? this.groupDetails.name : '';
        },
        groupDescription() {
            return this.groupDetails ? this.groupDetails.description : '';
        },
    },
    methods: {
        toggleSidebar() {
            const groupSidebar = document.getElementById('group-sidebar');
            const groupSidebarCloseIcon = document.getElementById('close-group-sidebar-icon');

            groupSidebar.classList.toggle('expand');
            groupSidebarCloseIcon.classList.toggle('hide');
        },

        deletegroup(groupId) {

            Swal.fire({
                    //title: "Tem certeza que deseja deletar esta tarefa?",
                    text: "Tem certeza que deseja deletar esta tarefa?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sim, deletar!",
                    cancelButtonText: "Voltar",

                }).then((result) => {

                if (result.isConfirmed) {

                    const url = `/api/v1/groups/${groupId}`;

                    axios.delete(url)
                        .then(response => {
                            console.log(response.data);
                            this.$emit('group-deleted', groupId);
                            this.closeModal();
                        })
                        .catch(error => {
                            console.log(error);
                        });

                        /*Swal.fire({
                        title: "Sucesso!",
                        text: "Sua tarefa foi deletada.",
                        icon: "success"
                        });*/

                }
            });

        },
    }
};

</script>
<style scoped>

    .input-text-group-sidebar {
        border: none;
        background-color: transparent;
    }

    .input-text-group-sidebar:focus-visible {
        outline: none;
    }

    .group-checkbox {
        cursor: pointer;
        width: 22px;
        height: 22px;
        margin-top: 10px;
        margin-right: 10px;
        border-radius: 36px;
    }

    .close-group-sidebar-icon {
        position: relative;
        top: -15px;
        right: 10px;
        cursor: pointer;
        float: right;
    }

    .group-title {
        font-size: 1.6rem;
        font-weight: 600;
        color: #e3e3e3
    }

    .group-description {
        font-size: 1.2rem;
        color: #a7a7a7;
    }

</style>
