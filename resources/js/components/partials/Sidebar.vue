<template>

    <aside id="sidebar" class="expand">

        <div class="d-flex">
            <button id="toggle-btn" type="button">
                <ViewGridOutlineIcon :size="30"/>
            </button>

            <div class="sidebar-logo">
                <a href="#" class="text-white">
                    Vinicius
                </a>
            </div>
        </div>

        <ul class="sidebar-nav">

            <!--<li class="sidebar-item">

                <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#home" aria-expanded="false" aria-controls="home">
                    <HomeIcon />
                    <span class="titulo-item-sidebar">Home</span>
                </a>

                <ul id="home" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <img src="/storage/icons/home.svg">
                            <span class="titulo-item-sidebar">Home 2</span>
                        </a>
                    </li>
                </ul>

            </li>-->


            <li class="sidebar-item">
                <a href="/home" class="sidebar-link">
                    <HomeIcon />
                    <span class="titulo-item-sidebar">Início</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="#" class="sidebar-link" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                    <PlusCircleOutlineIcon/>
                    <span class="titulo-item-sidebar">Nova tarefa</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="/groups" class="sidebar-link">
                    <ListStatusIcon />
                    <span class="titulo-item-sidebar">Grupos</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <PoundIcon />
                    <span class="titulo-item-sidebar">Tags</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <CalendarTodayOutlineIcon />
                    <span class="titulo-item-sidebar">Hoje</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <CalendarBlankIcon />
                    <span class="titulo-item-sidebar">Próximos dias</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <CheckCircleOutlineIcon />
                    <span class="titulo-item-sidebar">Concluídas</span>
                </a>
            </li>

            <div class="sidebar-group-divider" v-if="groupFound"></div>

            <li class="sidebar-item" v-if="groupFound" v-for="group in groups" :key="group.id">

                <a :href="'/groups/' + group.id" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#home" aria-expanded="false" aria-controls="home">
                    <span class="titulo-item-sidebar">{{ group.name }}</span>
                </a>

                <ul id="home" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <div class="titulo-item-sidebar">#</div>
                        </a>
                        <a href="#" class="sidebar-link">
                            <div class="titulo-item-sidebar">#</div>
                        </a>
                        <a href="#" class="sidebar-link">
                            <div class="titulo-item-sidebar">#</div>
                        </a>
                        <a href="#" class="sidebar-link">
                            <div class="titulo-item-sidebar">#</div>
                        </a>
                    </li>
                </ul>

            </li>



        </ul>

        <div class="sidebar-footer">
            <a class="sidebar-link" href="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <Logout />
                <span class="titulo-item-sidebar">Logout</span>
            </a>
        </div>

    </aside>

</template>

<script>

    import PlusCircleOutlineIcon from 'vue-material-design-icons/PlusCircleOutline.vue';
    import HomeIcon from 'vue-material-design-icons/Home.vue';
    import ListStatusIcon from 'vue-material-design-icons/ListStatus.vue';
    import PoundIcon from 'vue-material-design-icons/Pound.vue';
    import ViewGridOutlineIcon from 'vue-material-design-icons/ViewGridOutline.vue';
    import CalendarTodayOutlineIcon from 'vue-material-design-icons/CalendarTodayOutline.vue';
    import CalendarBlankIcon from 'vue-material-design-icons/CalendarBlank.vue';
    import CheckCircleOutlineIcon from 'vue-material-design-icons/CheckCircleOutline.vue';
    import Logout from 'vue-material-design-icons/Logout.vue';

    export default {
        name: 'SidebarComponent',
        props: ['appName', 'userId'],
        components: {
            PlusCircleOutlineIcon,
            HomeIcon,
            ListStatusIcon,
            PoundIcon,
            ViewGridOutlineIcon,
            CalendarTodayOutlineIcon,
            CalendarBlankIcon,
            CheckCircleOutlineIcon,
            Logout,
        },

        data() {
            return {
                groupFound: false,
                groups: [],
            };
        },

        mounted() {
            this.getGroups();
        },

        methods: {

            getGroups() {

                axios.get('/api/v1/groups')
                .then(response => {

                    this.groupFound = true;
                    this.groups = response.data;

                })
                .catch(error => {

                    if ((error.response.status == 404) && (error.response.data.message == 'No groups found')) {
                        console.log("No groups found");
                        this.groupFound = false;
                    }

                });
            },

        }
    }
</script>
