<template>
    <div :class="{'completed-account' : isCompleted}" class="card-work card-company">
        <div class="card-company-profile">
            <img alt="" class="card-work-company-logo" src="dist/img/logo-company.jpg">
            <div>
                <div class="card-company-name">Approved Cash Advance</div>
                <div class="mt-2">
                    <div class="card-company-short-info">Manager, Company (6-10 employees)</div>
                    <div class="card-company-short-info mt-1">South Boston, Boston MA</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        isCompleted: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {}
    }
}
</script>
