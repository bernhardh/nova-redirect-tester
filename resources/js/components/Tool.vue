<template>
    <div>
        <heading class="mb-6">Nova Redirect Tester</heading>

        <div class="text-center mb-5">
            <test-pill color="blue">{{ testRunning }} / {{ totalCount }} Running</test-pill>
            <test-pill color="green">{{ testSuccess }} / {{ totalCount }} Success</test-pill>
            <test-pill color="red">{{ testError }} / {{ totalCount }} Error</test-pill>
        </div>

        <div v-for="group in groups">
            <redirect-tester
                :name="group.name"
                :description="group.description"
                :items="group.items"
                @itemError="itemError"
                @itemSuccess="itemSuccess"
                class="mb-6">
            </redirect-tester>
        </div>
    </div>
</template>

<script>
import RedirectTester from "./RedirectTester";
import TestPill from "./TestPill";
export default {
    components: {TestPill, RedirectTester},
    data() {
        return {
            testRunning: 0,
            testSuccess: 0,
            testError: 0,
            groups: []
        }
    },
    mounted() {
        Nova.request()
            .get('/nova-vendor/nova-redirect-tester/redirects')
            .then(res => {
                this.groups = res.data;
                this.testRunning = this.totalCount;
            });
    },
    computed: {
        totalCount() {
            let count = 0;
            for(let i in this.groups) {
                count+= this.groups[i].items.length;
            }

            return count;
        }
    },
    methods: {
        itemSuccess() {
            this.testRunning--;
            this.testSuccess++;
        },
        itemError() {
            this.testRunning--;
            this.testError++;
        }
    }
}
</script>
