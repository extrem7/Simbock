<template>
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-5">
            <AboutBlock/>
            <PrivacyBlock/>
            <ContactBlock/>
            <SocialBlock/>
            <CompleteBlock v-if="$root.isLargeGrid"/>
        </div>
        <div class="col-xl-6 col-lg-8 col-md-7">
            <JobBlock/>
            <WorkExperienceBlock/>
            <EducationBlock/>
            <ResumeBlock/>
            <CertificatesBlock/>
            <SummaryBlock/>
            <ObjectiveBlock/>
            <AchievementsBlock/>
            <AssociationsBlock/>
            <SkillsBlock/>
            <MoreInfoBlock/>
            <CoverLetterBlock/>
            <LanguageBlock/>
            <PersonalStatementBlock/>
            <CarBlock/>
        </div>
        <div v-if="!$root.isLargeGrid" class="col-md-3">
            <CompleteBlock/>
        </div>
    </div>
</template>

<script>
import AboutBlock from "./AboutBlock"
import PrivacyBlock from "./PrivacyBlock"
import ContactBlock from "./ContactBlock"
import SocialBlock from "./SocialBlock"
import CompleteBlock from "./CompleteBlock"
import JobBlock from "./JobBlock"
import WorkExperienceBlock from "./WorkExperienceBlock"
import EducationBlock from "./EducationBlock"
import ResumeBlock from "./ResumeBlock"
import CertificatesBlock from "./CertificatesBlock"
import SummaryBlock from "./SummaryBlock"
import ObjectiveBlock from "./ObjectiveBlock"
import AchievementsBlock from "./AchievementsBlock"
import AssociationsBlock from "./AssociationsBlock"
import SkillsBlock from "./SkillsBlock"
import MoreInfoBlock from "./MoreInfoBlock"
import CoverLetterBlock from "./CoverLetterBlock"
import LanguageBlock from "./LanguageBlock"
import PersonalStatementBlock from "./PersonalStatementBlock"
import CarBlock from "./CarBlock"

export default {
    components: {
        CarBlock,
        PersonalStatementBlock,
        LanguageBlock,
        MoreInfoBlock,
        SkillsBlock,
        AssociationsBlock,
        AchievementsBlock,
        ObjectiveBlock,
        SummaryBlock,
        CertificatesBlock,
        PrivacyBlock,
        AboutBlock,
        ContactBlock,
        SocialBlock,
        CompleteBlock,
        JobBlock,
        WorkExperienceBlock,
        EducationBlock,
        ResumeBlock,
        CoverLetterBlock
    },
    created() {
        this.$store.commit('volunteer/setup', this.shared('volunteer'))
    }
}
</script>
