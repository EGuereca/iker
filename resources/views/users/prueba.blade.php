<div class="primary-box">
    <div class="container">
        <h2>Hombre y Mujeres</h2>

        <div class="gender">
            <div class="datails">
                <span>Hombres</span>
                <span>12</span>
            </div>
            <div class="menu">
                <div id="hombres-menu"></div>
            </div>
        </div>

        <div class="gender">
            <div class="datails">
                <span>Mujeres</span>
                <span>13</span>
            </div>
            <div class="menu">
                <div id="mujeres-menu"></div>
            </div>
        </div>

    </div>
</div>

<style>
    .primary-bx{
        width: 40%;
        min-width: absolute;
        position: absolute;
        transform: transalte(-50%, -50%);
        left: 50%;
        top: 50%
    }
    .container{
        width: 100%;
        padding: 30px 30px 50px;
        border: 2px solid rgba(0,0,0,0.06)
    }
    .contenedor *{
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: whitesmoke;
        font-weight: 500;
    }
    h2{
        margin-bottom: 50px;
        letter-spacing: 2px;
        text-align: center;
        font-size: 34px;
        font-weight: bold;
    }
    .skills:not(:last-child){
        margin-bottom: 30px;
    }
    .details{
        width: 100px;
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
</style>