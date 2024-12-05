import {createStore} from "vuex";
import user from './user.js';
import student from './student.js'
import teacher from './teacher.js'

export default createStore({
    modules: {
        user,
        student,
        teacher,
    },
});
