import Alert from "./includes/Alert"
import Logout from "./layout/Logout"
import MenuToggle from "./layout/MenuToggle"

export default {
    Alert,
    Logout,
    MenuToggle,

    ModelsMultiselect: () => import('./settings/ModelsMultiselect'),

    PagesIndex: () => import('./pages/Index'),
    PageForm: () => import('./pages/Form'),

    ArticlesIndex: () => import('./articles/Index'),
    ArticleForm: () => import('./articles/Form'),

    UsersIndex: () => import('./users/Index'),
    UserForm: () => import('./users/Form'),
}
