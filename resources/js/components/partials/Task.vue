<template>
    <div class="task">
        <div class="task-title">{{ task.title }}</div>
        <div class="task-description">{{ task.description }}</div>
    </div>
</template>

<script>
export default {
    name: 'TaskComponent',
    props: {
        task: {
            type: Object,
            required: true
        }
    }
};
</script>

<style scoped>

.task {
    padding: 10px;
    /*border: 1px solid #eee;
    border-radius: 4px;*/
    border-bottom: 1px solid #cdcdcd;
    margin-bottom: 10px;
}

.task-title {
    font-size: 1.2rem;
    font-weight: bold;
    color: #414141
}

.task-description {
    font-size: .9rem;
    color: #a7a7a7
}

</style>
