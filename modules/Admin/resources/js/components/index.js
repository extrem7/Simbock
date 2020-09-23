import Alert from "./includes/Alert"
import Logout from "./layout/Logout"
import MenuToggle from "./layout/MenuToggle"

export default {
    Alert,
    Logout,
    MenuToggle,

    ModelsMultiselect: () => import('./settings/ModelsMultiselect'),

    PagesIndex: () => import('./pages/Index'),
    PagesForm: () => import('./pages/Form'),

    ArticlesIndex: () => import('./blog/articles/Index'),
    ArticlesForm: () => import('./blog/articles/Form'),

    ArticleCategoriesIndex: () => import('./blog/categories/Index'),
    ArticleCategoriesForm: () => import('./blog/categories/Form'),

    UsersIndex: () => import('./users/Index'),
    UsersForm: () => import('./users/Form'),

    SectorsIndex: () => import('./jobs/sectors/Index'),
    SectorsForm: () => import('./jobs/sectors/Form'),

    RolesIndex: () => import('./jobs/roles/Index'),
    RolesForm: () => import('./jobs/roles/Form'),
}