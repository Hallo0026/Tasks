<template>

    <div class="accordion" :id="accordionId">

        <div class="accordion-item task-accordion-item">
            <div class="accordion-header">

                <button class="accordion-button task-accordion-header" type="button" data-bs-toggle="collapse" :data-bs-target="'#' + collapseId" aria-expanded="true" :aria-controls="collapseId">

                    <span class="task-accordion-title">
                        <slot name="header">
                            {{ title }}
                        </slot>
                    </span>

                </button>
            </div>
            <div :id="collapseId" class="accordion-collapse collapse show" :data-bs-parent="'#' + accordionId">

                <div class="task-group">

                    <div v-if="taskGroup">
                        <span class="task-accordion-group-title">
                            Tarefas de Teste
                        </span>

                        <div>
                            <slot></slot>
                        </div>

                    </div>


                    <div v-else>
                        <slot></slot>
                    </div>

                </div>


                <div>
                    <slot name="footer">

                    </slot>

                </div>

            </div>
        </div>
    </div>

</template>

<script>

    import ChevronDownIcon from 'vue-material-design-icons/ChevronDown.vue';
    import ChevronUpIcon from 'vue-material-design-icons/ChevronUp.vue';
    import PlusIcon from 'vue-material-design-icons/Plus.vue';

    export default {
        name: 'CardComponent',
        components: {
            ChevronDownIcon,
            ChevronUpIcon,
            PlusIcon
        },
        props: {
            title: {
                type: String,
                default: ''
            },
            canHideContent: {
                type: Boolean,
                default: false
            },
            counter: {
                type: Number,
                default: 0
            },
            accordionId: {
                type: String,
                required: true
            },
            collapseId: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                isVisible: true
            };
        },
        methods: {
            toggleVisibility() {
                this.isVisible = !this.isVisible;
            }
        }
    };
</script>
