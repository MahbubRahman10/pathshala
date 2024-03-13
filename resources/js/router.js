import Login from './Components/Authentication/Login.vue'

// Admin
import Userlist from './Components/Admin/Userslist.vue'
import Classlist from './Components/Classes/Classlist.vue'
import Classpupilslist from './Components/Classes/Classpupilslist.vue'
import Subjectslist from './Components/Subjects/Subjectslist.vue'

// Teacher
import AssignedSubjectslist from './Components/Teacher/Index.vue'
import TeacherSubject from './Components/Teacher/Subject.vue'
import TestResult from './Components/Teacher/Result.vue'
import AddTest from './Components/Teacher/Addtest.vue'
import EditTest from './Components/Teacher/Edittest.vue'
import TeacherTest from './Components/Teacher/Test.vue'

// Pupils
import PupilsSubject from './Components/Pupils/Subject.vue'
import PupilsTest from './Components/Pupils/Test.vue'


// Pupils
import Profile from './Components/Profile/Profile.vue'

export default[
	{ path: '/', component: Login  },
	{ path: '/user/login', component: Login  },
	{ path: '/admin/users', component: Userlist  },
	{ path: '/admin/classes', component: Classlist  },
	{ path: '/admin/subjects', component: Subjectslist  },
	{ path: '/admin/pupils', component: Classpupilslist  },

	{ path: '/teacher/index', component: AssignedSubjectslist  },
	{ path: '/teacher/subject/:id', component: TeacherSubject , name: 'Teachersubject' },
	{ path: '/teacher/testresult/:id', component: TestResult},
	{ path: '/teacher/addtest/:id', component: AddTest},
	{ path: '/teacher/edittest/:id', component: EditTest},
	{ path: '/teacher/test/:id', component: TeacherTest},

	{ path: '/pupils/subjects', component: PupilsSubject},
	{ path: '/pupils/tests/:id', component: PupilsTest},

	{ path: '/user/profile/', component: Profile},
]
