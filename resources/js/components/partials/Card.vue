<template>
    <div class="task-card">
        <div class="card-header">
            <slot name="header">{{ title }}</slot>
        </div>
        <div class="card-body">
            <slot></slot>
        </div>
        <div class="card-footer">
            <slot name="footer"></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CardComponent',
    props: {
        title: {
            type: String,
            default: ''
        }
    }
};
</script>
