<script setup>
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    solution: Object,
    errors: Object,
});

const gradeData = ref({
    grade: '',
    feedback: '',
});

const emit = defineEmits(['grade-saved']);

const saveGrade = async () => {
    try {
        await axios.post(`/api/grade/${props.solution.id}/${props.solution.student.id}`, gradeData.value);
        emit('grade-saved');
    } catch (error) {
        console.error(error);
    }
};
</script>

<template>
    <div>
        <div v-if="solution.grade" class="text-success align-content-center">
            <h6>Grade: {{solution.grade.grade}}</h6>
            <h6>Feedback: {{solution.grade.feedback}}</h6>
        </div>
        <div v-else>
            <form @submit.prevent="saveGrade">
                <div class="form-group">
                    <label>Grade</label>
                    <input v-model="gradeData.grade" class="form-control" type="text">
                </div>
                <div v-if="errors.grade" class="alert alert-danger my-1">
                    {{ errors.grade[0] }}
                </div>

                <div class="form-group">
                    <label>Feedback</label>
                    <textarea v-model="gradeData.feedback" class="form-control" required></textarea>
                </div>
                <div v-if="errors.feedback" class="alert alert-danger my-1">
                    {{ errors.feedback[0] }}
                </div>

                <div class="form-group my-3">
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>

</style>
