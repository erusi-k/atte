<template>
<div>
    <p>{{day.format('YYYY-MM-DD')}}</p>
    <p @click="addDay">→</p>
    <p @click="subtractDay">⇦</p>
    <p>これはテストです！</p>
    <p @click="requestData">データ取得ボタン</p>
    <p v-for="data in datas" :key="data.id">{{data.id}}</p>
    <ul class="pagination">
        <li class="inactive" :class="(current_page == 1) ? 'disabled':''" @click ="changePage(current_page-1)">＜＜</li>
        <li v-for="page in frontPageRange" :key="page" @click="changePage(page)" :class="(isCurrent(page)) ? 'active':'inactive'">{{page}}</li>
        <li v-show="front_dot" class="inactive disabled">...</li>
        <!-- <li v-for="page in middlePageRange" :key="page" @click="changePage(page)" :class="(isCurrent(page)) ? 'active':'inactive'">{{page}}</li> -->
        <li v-show="end_dot" class="inactive disabled">...</li>
        <li v-for="page in endPageRange" :key="page" @click="changePage(page)" :class="(isCurrent(page)) ? 'active':'inactive'">{{page}}</li>
        <li class="inactive" :class="(current_page >= last_page) ? 'disabled':''" @click="changePage(current_page+1)">＞＞</li>
    </ul>
</div>
</template>

<script>
import moment from "moment";

export default {
    data(){
        return {
            day:moment(),
            datas:'',
            current_page:1,
            last_page:'',
            range:5,
            front_dot:false,
            end_dot:false,
            size:1,
        }
    },
    created(){
        
    },
    computed:{
        frontPageRange(){
            // if(!this.sizeCheck){
            //     return this.calRange(1,this.last_page);
            // }
            return this.calRange(1,2);
        },
        middlePageRange(){
            let start = "";
            let end = "";
            if(!this.sizeCheck){
                return [];
            }
            if(this.current_page <= this.range){
                start = 3;
                end = this.range + 2;
                this.front_dot = false;
                this.end_dot = true;
            }else if (this.current_page > this.last_page - this.range){
                start = this.last_page - this.range -1;
                end = this.last_page - 2;
                this.front_dot = true;
                this.end_dot = false;
            } else {
                start = this.current_page - Math.floor(this.range / 2);
                end = this.current_page + Math.floor(this.range / 2);
                this.front_dot = true;
                this.end_dot = true;
            }
            return this.calRange(start,end);
        },
        endPageRange(){
            return this.calRange(this.last_page-1, this.last_page);
        },
        sizeCheck(){
            if(this.last_page < this.size) {
                return false;
            }
                return true;
        }
        
    },

    methods:{
        addDay(){
            let day = moment(this.day);
            this.day = day.add(1,'days');
        },
        subtractDay(){
            let day = moment(this.day);
            this.day = day.subtract(1,'days');
        },
        async requestData(){
            let item = this.day.format('YYYY-MM-DD')
            const request =await axios.get(`http://localhost:8000/api/datarequest?page=${this.current_page}`,{params:{day:item}});
            this.datas = request.data.data.data;
            this.current_page = request.data.data.current_page;
            this.last_page = request.data.data.last_page;

            console.log(request.data);
            console.log(request.data.day);
            this.check();
        },
        calRange(start,end){
            const renge = [];
            for(let i = start;i <= end; i++){
                renge.push(i);
            }
            return renge;
        },
        changePage(page){
            if(page > 0 && page <= this.last_page){
                this.current_page = page;
                this.requestData();
            }
        },
        isCurrent(page){
            return page === this.current_page;
        },

        check(){
            console.log(this.last_page);
        }
        
    }

}
</script>

<style scoped>
.pagination {
    display:flex;
    list-style-type:none;
}
.pagination li {
    border:1px solid #ddd;
    padding:6px 12px;
    text-align: center;
}

.pagination li + li {
    border-left:none;
}

.active {
    background-color:aqua;
}

.disabled { 
    cursor:not-allowed;
}
</style>

