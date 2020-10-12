<template>
    <div class="w-100">
        <div class="job-settings">
            <div class="job-settings-statistics">
                <div class="job-settings-statistics-item">1 <span class="d-block extra-small-size line-height-1">Day posted</span>
                </div>
                <img alt="divider" src="dist/img/icons/divider.svg">
                <div class="job-settings-statistics-item">0 <span class="d-block extra-small-size line-height-1">Visitors</span>
                </div>
                <img alt="divider" src="dist/img/icons/divider.svg">
                <a class="job-settings-statistics-item link-inherit" href="">View <span
                    class="d-block extra-small-size line-height-1">Candidates</span></a>
            </div>
            <div class="job-status job-status-draft">Draft</div>
            <button class="btn btn-outline-violet btn-flex btn-sm btn-job-post btn-scale-active">
                <svg-vue class="mr-1" icon="arrow-up"></svg-vue>
                Post vacancy
            </button>
            <div class="job-settings-actions mt-1">
                <button class="btn btn-flex btn-job-action">
                    <svg-vue class="mr-2" icon="stop"></svg-vue>
                    Stop post
                </button>
                <button class="btn btn-flex btn-job-action">
                    <svg-vue class="mr-2" icon="cancel"></svg-vue>
                    Close post
                </button>
                <button class="btn btn-flex btn-job-action">
                    <svg-vue class="mr-2" icon="pen"></svg-vue>
                    Edit
                </button>
                <button class="btn btn-flex btn-job-action">
                    <svg-vue class="mr-2" icon="binocl"></svg-vue>
                    Preview
                </button>
                <button class="btn btn-flex btn-job-action">
                    <svg-vue class="mr-2" icon="copy"></svg-vue>
                    Duplicate
                </button>
                <button class="btn btn-flex btn-job-action">
                    <svg-vue class="mr-2" icon="delete"></svg-vue>
                    Delete
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isShowInfo: true
        }
    }
}
</script>
