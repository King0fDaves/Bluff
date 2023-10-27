<div class="Creator">
    <h2 class="Creator__intro">
        Created soley by
    </h2>

    <span class="Creator__name">
        David Gosoe
    </span>
</div>

<style lang="scss">
.Creator{
    font-family: $primaryFont;
    margin: auto;
    width: 100vw;
    text-align: center;
}


.Creator__intro{
    color: rgb(211, 211, 211);
    
}

.Creator__name{

    @include gradientText( -webkit-linear-gradient(50deg,rgb(92, 92, 224), rgb(41, 170, 255)));  
    
    font-size: 1.5rem;
    text-transform: uppercase;
    font-family: 'Zekton';
    letter-spacing: .1rem;
}
</style>


