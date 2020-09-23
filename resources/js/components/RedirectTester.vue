<template>
    <div>
        <card>
            <h3 class="p-3">
                {{ name }}

                <redirect-status :status="testRunning ? 'loading' : (testError > 0 ? 'error' : 'success')"></redirect-status>

                <span v-if="description" :title="description" class="align-middle" >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm0-9a1 1 0 0 1 1 1v4a1 1 0 0 1-2 0v-4a1 1 0 0 1 1-1zm0-4a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>
                </span>

                <div class="float-right text-sm">
                    <test-pill color="blue">{{ testRunning }} Running</test-pill>
                    <test-pill color="green">{{ testSuccess }} Success</test-pill>
                    <test-pill color="red">{{ testError }} Error</test-pill>
                </div>
            </h3>

            <table class="table w-full table-default">
                <thead>
                <tr><th>Url from</th><th>Url to</th><th>Status</th><th>Result</th></tr>
                </thead>
                <tbody>
                <tr v-for="item in formatedItems">
                    <td>
                        <a :href="item.url_from" target="_blank" class="text-primary no-underline">{{ item.url_from_formated.path }}</a>
                        <br><small>{{ item.url_from_formated.domain }}</small>
                    </td>
                    <td>
                        <a :href="item.url_to" target="_blank" class="text-primary no-underline">{{ item.url_to_formated.path }}</a>
                        <br><small>{{ item.url_to_formated.domain }}</small>
                    </td>
                    <td>{{ item.status }}</td>
                    <td class="text-center">
                        <redirect-status :status="item.result.type"></redirect-status>
                        <span v-html="item.result.msg"></span>
                    </td>
                </tr>
                </tbody>
            </table>
        </card>
    </div>
</template>

<script>
import TestPill from "./TestPill";
import RedirectStatus from "./RedirectStatus";
export default {
    components: {RedirectStatus, TestPill},
    props: {
        name: {},
        description: {},
        items: {
            default: () => []
        }
    },
    data() {
        return {
            testRunning: 0,
            testSuccess: 0,
            testError: 0,
        }
    },
    mounted() {
        this.checkItems();
    },
    computed: {
        formatedItems() {
            let items = [];

            for(let i in this.items) {
                const item = this.items[i];
                items.push(_.extend({
                    url_from_formated: this.splitUrl(item.url_from),
                    url_to_formated: this.splitUrl(item.url_to),
                    result: {}
                }, item));
            }

            return items;
        }
    },
    methods: {
        splitUrl(url) {
            const reg = /.+?\:\/\/.+?(\/.+?)(?:#|\?|$)/,
                split = url && reg.exec(url),
                path = split && split[1];

            return path ? {
                path: path,
                domain: url.substr(0, url.length - path.length)
            } : {};
        },
        checkItems() {
            this.testRunning = this.items.length;
            this.testSuccess = 0;
            this.testError = 0;

            for(let i in this.items) {
                this.checkItem(this.items[i], i);
            }
        },
        itemSuccess() {
            this.testSuccess++;
            this.$emit("itemSuccess", 1);

            return {
                type: "success"
            };
        },
        itemError(msg) {
            this.testError++;
            this.$emit('itemError', 1);

            return {
                type: 'error',
                msg: msg
            };
        },
        checkItem(item, index) {
            fetch(item.url_from, {method: 'HEAD'}).then((res) => {
                item.status = res.status;

                if(item.expected_status_code == 404 && res.status === 404) {
                    item.result = this.itemSuccess();
                }
                else if(res.status !== 200) {
                    item.result = this.itemError('Wrong status code');
                }
                else if(res.redirected && item.url_to !== res.url) {
                    item.result = this.itemError('Wrong <a href="' + res.url + '" title="' + res.url + '" target="_blank" class="text-primary no-underline">Url</a>');
                }
                else {
                    item.result = this.itemSuccess();
                }

                // Update item
                this.testRunning--;
                this.$set(this.items, index, item);
            });
        }
    }
}
</script>
