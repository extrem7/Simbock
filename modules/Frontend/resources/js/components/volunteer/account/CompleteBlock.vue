<template>
    <div class="sector sector-sidebar sector-progress-info">
        <div class="sector-label invisible">Progress</div>
        <div class="item-box">
            <div class="sector-body">
                <div class="sector-body-inner">
                    <div class="radial-progress-bar-wrapper">
                        <radial-progress-bar :completed-steps="1"
                                             :diameter="72"
                                             :inner-stroke-width="4"
                                             :stroke-width="4"
                                             :total-steps="2"
                                             inner-stroke-color="#DFDFDF"
                                             start-color="#5CEDAA"
                                             stop-color="#5CEDAA"
                                             stroke-linecap="butt">
                        </radial-progress-bar>
                        <span class="semi-bold-weight radial-progress-bar-value">{{ 2 }}%</span>
                    </div>
                    <div class="sector-name semi-bold-weight">Your Profile is Incomplete</div>
                    <div class="extra-small-size mt-2">Finish your profile to unlock better job matching and
                        stand out to hiring managers!
                    </div>
                    <div class="sector-progress-step">
                        <div class="progress-step-item fill-step">
                            <div class="progress-step-circle"></div>
                            <button class="btn btn-sector-link btn-rotate-icon btn-flex">Add Resume
                                <svg-vue icon="plus"></svg-vue>
                            </button>
                        </div>
                        <div class="progress-step-item">
                            <div class="progress-step-circle"></div>
                            <button class="btn btn-sector-link btn-rotate-icon btn-flex">Add Phone Number
                                <svg-vue icon="plus"></svg-vue>
                            </button>
                        </div>
                        <div class="progress-step-item">
                            <div class="progress-step-circle"></div>
                            <button class="btn btn-sector-link btn-rotate-icon btn-flex">Add Skills
                                <svg-vue icon="plus"></svg-vue>
                            </button>
                        </div>
                        <div class="progress-step-item">
                            <div class="progress-step-circle"></div>
                            <button class="btn btn-sector-link btn-rotate-icon btn-flex">Add Headline
                                <svg-vue icon="plus"></svg-vue>
                            </button>
                        </div>
                        <div class="progress-step-item">
                            <div class="progress-step-circle"></div>
                            <button class="btn btn-sector-link btn-rotate-icon btn-flex">Receive a Reference
                                <svg-vue icon="plus"></svg-vue>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sector-footer text-center">
                <a class="link-inherit small-size" href="">I got hired!</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {}
</script>
