import Vue from 'vue'

import './plugins'
import './filters'

import components from './components'
import store from './store'

const app = new Vue({
    components,
    el: '#app',
    store,
    data() {
        return {
            // на пк версиях где поиск, при скролле добавляется к шапке чтоб скрыть шапку и оставить строку поиска
            isScrolledSearch: false,
            isLargeGrid: false,
            isMobileGrid: false,
            isOpenMessage: false,
            //изначальный скролл = 0
            scroll: 0,
            //прогрессбар настрокй
            completedSteps: 75,
            innerStrokeColor: '#fff',
            startColor: '#000',
            totalSteps: 100,
            //открывает cover letter
            isOpenText: false,
            //флаг или кудато до скролили куда надо а именно для кнопки вверх для ее появления
            scrolled: false,
            optionsSelect: ['Choose your sector', 'Account manager', 'Apprenticeships', 'Admin', 'Education', 'Energy', 'Banking', 'Simbok', 'Fifa', 'Raxkor', 'Iphone', ' Admin, Secretarial & PA',
                'Customer Service', 'Construction & Property', ' Charity & Voluntary'],
            sizes: ['Small', 'Medium', 'Large', 'Extra Large', 'Small', 'Medium', 'Large', 'Extra Large', 'Small', 'Medium', 'Large', 'Extra Large', 'Small', 'Medium', 'Large', 'Extra Large'],
        }
    },
    created() {
        window.addEventListener("scroll", this.handleScroll);
    },
    beforeMount() {
        window.addEventListener("resize", this.isCheckGrid, false);
        window.addEventListener("load", this.isCheckGrid, false);
    },
    mounted() {
        let links = document.querySelectorAll(".navigate-by-page-link");

        //якоря для страниц (Policy)
        links.forEach((link) => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                let href = link.getAttribute('href').replace("#", '');
                console.log(href)
                let scrollTo = document.getElementById(href).getBoundingClientRect().top - 100;
                window.scrollTo({top: scrollTo, behavior: 'smooth'});
            });
        })

        this.socialPopups()
    },
    destroyed() {
        window.removeEventListener('scroll', this.handleScroll);
    },
    methods: {
        handleScroll(event) {
            let top = window.pageYOffset;
            // на пк версиях где поиск, при скролле добавляется к шапке чтоб скрыть шапку и оставить строку поиска
            if (window.innerWidth > 991) {
                this.isScrolledSearch = top > 70;
            }
            //кнопка вверх появления и тд
            if (this.scroll > top) {
                this.scrolled = false;
            } else if (top > 400) {
                this.scrolled = true;
            }

            this.scroll = top;
        },
        scrollToHeader() {
            //клики на кнопку вверух
            window.scrollTo({top: 0, behavior: 'smooth'});
        },
        //проверка для размеры для того чтоб скрывать коегде html блоки
        isCheckGrid() {
            this.isLargeGrid = window.innerWidth < 1200;
            this.isMobileGrid = window.innerWidth < 768;
        },
        socialPopups() {
            const popupSize = {
                width: 780,
                height: 550
            };

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
                });
            })
        }
    },
})

store.app = app
