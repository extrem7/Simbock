import Vue from 'vue'

import './plugins'
import './filters'

import components from './components'
import pages from './pages'

import store from './store'

const app = new Vue({
    components: {
        ...components,
        ...pages
    },
    el: '#app',
    store,
    data() {
        return {
            isLargeGrid: false,
            isMobileGrid: false,
            isOpenMessage: false,
            //изначальный скролл = 0
            scroll: 0
        }
    },
    async beforeCreate() {
        if (shared('user')) {
            const {ToastPlugin} = await import('bootstrap-vue')
            ToastPlugin.install(Vue)
        }
    },
    created() {
        const user = this.shared('user')
        if (user) this.$store.commit('setUser', user)
    },
    beforeMount() {
        window.addEventListener('resize', this.isCheckGrid, false)
        window.addEventListener('load', this.isCheckGrid, false)
    },
    mounted() {
        let links = document.querySelectorAll('.navigate-by-page-link')

        //якоря для страниц (Policy)
        links.forEach((link) => {
            link.addEventListener('click', (e) => {
                e.preventDefault()
                let href = link.getAttribute('href').replace('#', '')
                console.log(href)
                let scrollTo = document.getElementById(href).getBoundingClientRect().top - 100
                window.scrollTo({top: scrollTo, behavior: 'smooth'})
            })
        })

        this.socialPopups()
    },
    methods: {
        //проверка для размеры для того чтоб скрывать коегде html блоки
        isCheckGrid() {
            this.isLargeGrid = window.innerWidth < 1200
            this.isMobileGrid = window.innerWidth < 768
        },
        socialPopups() {
            const popupSize = {
                width: 780,
                height: 550
            }

            const links = document.querySelectorAll('.article-share-item')

            links.forEach((link) => {
                link.addEventListener('click', (e) => {
                    const verticalPos = Math.floor((innerWidth - popupSize.width) / 2),
                        horisontalPos = Math.floor((innerHeight - popupSize.height) / 2)

                    const popup = window.open(link.getAttribute('href'), 'social',
                        'width=' + popupSize.width + ',height=' + popupSize.height +
                        ',left=' + verticalPos + ',top=' + horisontalPos +
                        ',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1')

                    if (popup) {
                        popup.focus()
                        e.preventDefault()
                    }
                })
            })
        }
    },
})

store.app = app
