<style>
    .dashboard-title .links {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    .dashboard-title .links > a {
        padding: 0 25px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
        color: #fff;
    }
    .dashboard-title h1 {
        font-weight: 200;
        font-size: 2.5rem;
    }
</style>

<div class="dashboard-title card bg-primary">
    <div class="card-body">
        <div class="text-center ">
            <div class="text-center mb-1">
                <h1 class="mb-3 mt-2 text-white">新用戶增长看板</h1>
                <div class="links">
                    <a href="javascript:void(0)">今日增长: {{ $count['day'] }}</a>
                    <a href="javascript:void(0)">本月增长: {{ $count['month'] }}</a>
                    <a href="javascript:void(0)">本年增长: {{ $count['year'] }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
