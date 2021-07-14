<template>
    <main class="container content-inner">
        <div class="form-box sign-box form-box-decorative_bg mx-auto">
            <div class="text-center mb-4">
                <img alt="logo" class="header-logo" src="/dist/img/logo.svg">
            </div>
            <BTabs>
                <RegisterForm
                    :is-active="!employer"
                    title="I'm a Job Seeker"/>
                <RegisterForm
                    :is-active="employer"
                    is-company
                    title="I'm an Employer"/>
            </BTabs>
        </div>
    </main>
</template>

<script>
import {BTabs} from 'bootstrap-vue'
import RegisterForm from '~/components/auth/Register'

export default {
    components: {BTabs, RegisterForm},
    data: () => ({
        employer: new URLSearchParams(location.search).has('employer')
    })
}
</script>

