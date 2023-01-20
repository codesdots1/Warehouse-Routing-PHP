<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <style>
body{padding: 0; margin: 0;}
.main-container {
    text-align: left;
    display: flex;
    justify-content: center;
    align-items: center;
    align-content: center;
    /* height: 100vh; */
}
.outer-container{  border: 2px solid #000;     padding: 50px;}
.inner-container {
    vertical-align: top;
    display: flex;
    flex-direction: row;

    /* column-gap: 50px; */
    align-content: space-around;
    align-items: center;
    width: auto;
    justify-content: space-around;
}   
.section-block span {
    border-bottom: 2px solid #000;
    padding: 20px;
    display: block;
    cursor: pointer;
}
.section-block span:last-child {
    border-bottom: 0;
}
.section-block {
    display: inline-block;
    flex-wrap: wrap;
    border: 2px solid #000;
    flex-direction: column;
}
.inner-block:first-child {
    border-right: 2px solid #000;
}
.section-block.two-column {
    display: flex;
    flex-direction: row;
}
button {
    padding: 5px;
    border: 2px solid;
    background: transparent;
    text-align: left;
    height: 100px;
    font-size: 17px;
    margin-inline: 50px;
    margin-block-start: 40px;
}
/* .step span {
    background: #58ff1c;
    padding: 30px;
    border: none;
} */
span:empty{
    background: #fff;
    padding: 29px;
    cursor: default;
    /* border: none; */
}
.pick{
    background: #bc59c6;
}
.wait{
    background: #bc59c6;
}
span.step{
    background: #69d460;
}
span.double-step{
    background: #3c9934;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script type="text/javascript">
    var select = function(param) {        
        if(param.classList.contains('pick')){
            param.classList.remove('pick');
        }/*else if(document.querySelectorAll('.pick').length == 4){
            alert("you can not select more than 4 blocks");
            return false;
        }*/else{
            param.classList.add('pick');
        }
    };
    
    // function showpanel() {     
    //     $(".outer-container").hide();
    //     $(".outer-container").fadeIn(3000);
    // }

    function getPositive(number) {
        // if number is less than zero multiply with -1, otherwise returns as it is
        return number < 0 ? number * -1 : number;
    }
    function Validator(){
        
        var rows = [['A', 'B'], ['C', 'D'], ['E', 'F'], ['G', 'H'], ['I', 'J']];
        
        var pickedBlocks = [];
        $('.pick').each(function(i, obj) {
            pickedBlocks.push(obj.innerHTML);
        });

        $.ajax({
            url: 'path.php',
            type: 'post',
            data: {array: pickedBlocks},
            success: function(data){
                // console.log(data);
                $("span:empty").css("background",'#fff');
                var array = $.parseJSON(data);
                var step;
                var blocks;
                var stepColor;
                
                $("#stepDetails").html('');
                $.each(array, function(index1, arr){
                    
                   
                    $(".outer-container").delay(1000).fadeIn();
                    // console.log(JSON.stringify(arr));
                    step = arr.pop();
                    blocks = arr.pop();                                    
                    // console.log(JSON.stringify(blocks))
                    $('.pick').each(function(i, obj) {
                        // console.log( obj.innerHTML)
                        if(jQuery.inArray( obj.innerHTML, blocks ) == -1){
                            $(this).addClass('wait');
                        }else if($(this).hasClass('wait')){
                            // console.log('in2')
                            $(this).removeClass('wait');
                        }                        
                    });
                    // $('h4').html(step+' Steps');

                    stepColor = Math.floor(Math.random()*16777215).toString(16).slice(-6);
                    $.each(arr, function(index, value){
                        $('.'+value[0]+value[1]).css("background",'#'+stepColor);
                        if(value[0]!=previous && value[0]>previous){
                            $('.0'+value[0]+value[1]).css("background",'#'+stepColor);
                            $('.1'+value[0]+value[1]).css("background",'#'+stepColor);
                        }else if(value[0]!=previous && value[0]<previous){
                            $('.0'+previous+value[1]).css("background",'#'+stepColor);
                            $('.1'+previous+value[1]).css("background",'#'+stepColor);
                        }
                        
                        previous = value[0];
                        
                    });
                    // console.log(stepColor);
                    var alphabetNum;
                    var rVal;
                    var cVal;
                    var diff;
                    var direction;
                    var direction1;
                    var tempArr = arr;
                    var preBlock = [0,0];
                    var flag = false;
                    var flag1 = false;
                    
                    $("#stepDetails").append("<h2>Loop "+(index1+1)+"</h2>")
                    $("#stepDetails").append("<h4>"+step+" Steps</h4>")
                    $("#stepDetails").append("<p> Start at depot</p>").css("font-weight", "bold")
                    $.each(blocks, function(i, v){
                        // console.log(v)
                        rVal = v.substr(0,1);
                        cVal = v.substr(-1);
                        $.each(rows, function(index, value){
                            if ($.inArray( rVal, value ) !== -1) {                                
                                alphabetNum = index;
                            }
                        })
                        if(preBlock[0]==alphabetNum && preBlock[1]==parseInt(cVal)){
                            // console.log(v+'~')
                            // direction = '';
                            step = 0;
                            $("#stepDetails").append("<p> get item from " + v + "</p>").css("font-weight", "bold");
                            flag1 = true; 
                            // return false;
                        }else if(preBlock[0]!=alphabetNum){
                            
                            if(preBlock[0]<alphabetNum){
                                // console.log(preBlock);
                                // console.log('in0');
                                if((preBlock[1]<parseInt(cVal) || preBlock[1]>=parseInt(cVal)) && (preBlock[1]>4 || parseInt(cVal)>4) &&  preBlock[1]!=0){
                                    // console.log('in1');
                                    direction1 = 'Up';
                                    $("#stepDetails").append("<p>Move Up " + (9-(tempArr[0][1]-1)) + " steps</p>").css("font-weight", "bold");
                                    for(i=0;i<=(9-tempArr[0][1]);i++){
                                        tempArr.shift()
                                    }
                                }else if((preBlock[1]<parseInt(cVal) || preBlock[1]>=parseInt(cVal)) && (preBlock[1]<=4 && parseInt(cVal)<=4) &&  preBlock[1]!=0){
                                    // console.log('in2');
                                    direction1 = 'Down';
                                    $("#stepDetails").append("<p>Move Down " + (tempArr[0][1]+1) + " steps</p>").css("font-weight", "bold");
                                    for(i=0;i<=tempArr[0][1];i++){
                                        tempArr.shift()
                                    }
                                }
                                direction = 'Right';
                            }
                            else if(preBlock[0]>alphabetNum){
                                
                                if(preBlock[1]>4){
                                    direction1 = 'Up';
                                    
                                    $("#stepDetails").append("<p>Move Up " + (9-(preBlock[1])) + " steps</p>").css("font-weight", "bold");
                                    for(i=0;i<=(9-(preBlock[1]));i++){
                                        tempArr.shift()
                                    }
                                }else{
                                    // console.log("in3");
                                    direction1 = 'Down';
                                    $("#stepDetails").append("<p>Move Down " + (tempArr[0][1]+1) + " steps</p>").css("font-weight", "bold");
                                    for(i=0;i<=tempArr[0][1];i++){
                                        tempArr.shift()
                                    }
                                }
                                direction = 'Left';

                            }
                            step = parseInt(preBlock[0]-alphabetNum);
                            for(i=0;i<=parseInt(preBlock[0]-alphabetNum);i++){
                                tempArr.shift()
                            }
                            flag = true;
                            $("#stepDetails").append("<p>Move "+direction+" " + getPositive(step)*3 + " steps</p>").css("font-weight", "bold");
                        }
                        $.each(tempArr, function(index, value){
                            if(flag1){
                                // console.log(v+'!')
                                flag1 = false;
                                return false;
                            }
                            if(value[0]==alphabetNum && value[1]==parseInt(cVal)){
                                
                                if(preBlock[0]==alphabetNum){
                                    // console.log('in')
                                    

                                    if(preBlock[1]>parseInt(cVal))
                                    direction = 'Down';
                                    else
                                    direction = 'Up';
                                    step = parseInt(preBlock[1]-parseInt(cVal));
                                    // if(direction1!='' && direction1=='Up' ){
                                    //     // console.log(direction1)
                                    //     direction = 'Down';
                                    //     step = parseInt(9-parseInt(cVal));
                                    // }
                                    // else if(direction1!='' && direction1=='Down' ){
                                    //     // console.log(direction1)
                                    //     direction = 'Up';
                                    //     step = parseInt(cVal);
                                    // }
                                    // step = index;
                                    for(i=0;i<=index;i++){
                                        tempArr.shift()
                                    }
                                    $("#stepDetails").append("<p>Move "+direction+" "+ getPositive(step) + " steps, get item from " + v + "</p>").css("font-weight", "bold");
                                    preBlock = [alphabetNum, parseInt(cVal)];
                                }else if(flag){
                                    
                                    if(preBlock[1]>parseInt(cVal))
                                    direction = 'Down';
                                    else
                                    direction = 'Up';
                                    // step = index;
                                    step = parseInt(preBlock[1]-parseInt(cVal));
                                    if(direction1!='undefined' && direction1!='' && direction1=='Up' ){
                                        direction = 'Down';
                                        step = parseInt(9-parseInt(cVal));
                                    }
                                    else if(direction1!='undefined' && direction1!='' && direction1=='Down' ){
                                        direction = 'Up';
                                        step = parseInt(cVal);
                                    }
                                    for(i=0;i<=index;i++){
                                        tempArr.shift();
                                    }
                                    $("#stepDetails").append("<p>Move "+direction+" "+ getPositive(step) + " steps, get item from " + v + "</p>").css("font-weight", "bold");
                                    preBlock = [alphabetNum, parseInt(cVal)];
                                }
                                flag = false;
                                return false;
                            }
                            // if(value === [alphabetNum,parseInt(cVal)]){
                            //     console.log('value')
                            // }
                        })
                        
                    })
                    // console.log(tempArr[0][0])
                    if(tempArr[0][0] == 0){
                        $("#stepDetails").append("<p>Move Down " + (tempArr[0][1]+1) + " steps, drop off items at depot</p>").css("font-weight", "bold");
                        for(i=0;i<=tempArr[0][1];i++){
                            tempArr.shift()
                        }
                    }else{
                        $("#stepDetails").append("<p>Move Down " + (tempArr[0][1]+1) + " steps</p>").css("font-weight", "bold");
                        for(i=0;i<=tempArr[0][1];i++){
                            tempArr.shift()
                        }
                        $("#stepDetails").append("<p>Move Left " + (alphabetNum*3) + " steps, drop off items at depot</p>").css("font-weight", "bold");
                        // console.log(tempArr[0][0])
                        for(i=0;i<=alphabetNum;i++){
                            tempArr.shift()
                        }
                        tempArr.shift()
                    }
                    
                    // console.log(tempArr);
                    
                    var previous = null;
                    
                    // $(".outer-container").fadeOut(300);
                    // return false;
                    
                });
            }
        })

        return(false);
    }
    
    </script>

</head>
<body>

    <div>
        <form target="" action="" class="main-container">            
            <div class="outer-container">
                <div id="stepDetails"></div>
                <div class="inner-container">
                    <div class="section-block">
                            <span></span>
                            <span onclick="select(this)">A8</span>
                            <span onclick="select(this)">A7</span>
                            <span onclick="select(this)">A6</span>
                            <span onclick="select(this)">A5</span>
                            <span onclick="select(this)">A4</span>
                            <span onclick="select(this)">A3</span>
                            <span onclick="select(this)">A2</span>
                            <span onclick="select(this)">A1</span>
                            <span></span>
                    </div>
                    <div class="section-block">
                            <span class="09"></span>
                            <span class="08"></span>
                            <span class="07"></span>
                            <span class="06"></span>
                            <span class="05"></span>
                            <span class="04"></span>
                            <span class="03"></span>
                            <span class="02"></span>
                            <span class="01"></span>
                            <span class="00"></span>
                    </div>
                    <div class="section-block two-column">
                        <div class="inner-block">
                            <span class="019"></span>
                            <span onclick="select(this)">B8</span>
                            <span onclick="select(this)">B7</span>
                            <span onclick="select(this)">B6</span>
                            <span onclick="select(this)">B5</span>
                            <span onclick="select(this)">B4</span>
                            <span onclick="select(this)">B3</span>
                            <span onclick="select(this)">B2</span>
                            <span onclick="select(this)">B1</span>
                            <span class="010"></span>
                        </div>
                        <div class="inner-block">   
                            <span class="119"></span>               
                            <span onclick="select(this)">C8</span>
                            <span onclick="select(this)">C7</span>
                            <span onclick="select(this)">C6</span>
                            <span onclick="select(this)">C5</span>
                            <span onclick="select(this)">C4</span>
                            <span onclick="select(this)">C3</span>
                            <span onclick="select(this)">C2</span>
                            <span onclick="select(this)">C1</span>
                            <span class="110"></span>
                        </div>
                    </div>
                    <div class="section-block">
                            <span class="19"></span>
                            <span class="18"></span>
                            <span class="17"></span>
                            <span class="16"></span>
                            <span class="15"></span>
                            <span class="14"></span>
                            <span class="13"></span>
                            <span class="12"></span>
                            <span class="11"></span>
                            <span class="10"></span>
                    </div>
                    <div class="section-block two-column">
                        <div class="inner-block">
                            <span class="029"></span>
                            <span onclick="select(this)">D8</span>
                            <span onclick="select(this)">D7</span>
                            <span onclick="select(this)">D6</span>
                            <span onclick="select(this)">D5</span>
                            <span onclick="select(this)">D4</span>
                            <span onclick="select(this)">D3</span>
                            <span onclick="select(this)">D2</span>
                            <span onclick="select(this)">D1</span>
                            <span class="020"></span>
                        </div>
                        <div class="inner-block">
                            <span class="129"></span>
                            <span onclick="select(this)">E8</span>
                            <span onclick="select(this)">E7</span>
                            <span onclick="select(this)">E6</span>
                            <span onclick="select(this)">E5</span>
                            <span onclick="select(this)">E4</span>
                            <span onclick="select(this)">E3</span>
                            <span onclick="select(this)">E2</span>
                            <span onclick="select(this)">E1</span>
                            <span class="120"></span>
                        </div>
                    </div>
                    <div class="section-block">
                            <span class="29"></span>
                            <span class="28"></span>
                            <span class="27"></span>
                            <span class="26"></span>
                            <span class="25"></span>
                            <span class="24"></span>
                            <span class="23"></span>
                            <span class="22"></span>
                            <span class="21"></span>
                            <span class="20"></span>
                    </div>
                    <div class="section-block two-column">
                        <div class="inner-block">
                            <span class="039"></span>
                            <span onclick="select(this)">F8</span>
                            <span onclick="select(this)">F7</span>
                            <span onclick="select(this)">F6</span>
                            <span onclick="select(this)">F5</span>
                            <span onclick="select(this)">F4</span>
                            <span onclick="select(this)">F3</span>
                            <span onclick="select(this)">F2</span>
                            <span onclick="select(this)">F1</span>
                            <span class="030"></span>
                        </div>
                        <div class="inner-block">
                            <span class="139"></span>
                            <span onclick="select(this)">G8</span>
                            <span onclick="select(this)">G7</span>
                            <span onclick="select(this)">G6</span>
                            <span onclick="select(this)">G5</span>
                            <span onclick="select(this)">G4</span>
                            <span onclick="select(this)">G3</span>
                            <span onclick="select(this)">G2</span>
                            <span onclick="select(this)">G1</span>
                            <span class="130"></span>
                        </div>
                    </div>
                    <div class="section-block">
                            <span class="39"></span>
                            <span class="38"></span>
                            <span class="37"></span>
                            <span class="36"></span>
                            <span class="35"></span>
                            <span class="34"></span>
                            <span class="33"></span>
                            <span class="32"></span>
                            <span class="31"></span>
                            <span class="30"></span>
                    </div>
                    <div class="section-block two-column">
                        <div class="inner-block">
                            <span class="049"></span>
                            <span onclick="select(this)">H8</span>
                            <span onclick="select(this)">H7</span>
                            <span onclick="select(this)">H6</span>
                            <span onclick="select(this)">H5</span>
                            <span onclick="select(this)">H4</span>
                            <span onclick="select(this)">H3</span>
                            <span onclick="select(this)">H2</span>
                            <span onclick="select(this)">H1</span>
                            <span class="040"></span>
                        </div>
                        <div class="inner-block">
                            <span class="149"></span>
                            <span onclick="select(this)">I8</span>
                            <span onclick="select(this)">I7</span>
                            <span onclick="select(this)">I6</span>
                            <span onclick="select(this)">I5</span>
                            <span onclick="select(this)">I4</span>
                            <span onclick="select(this)">I3</span>
                            <span onclick="select(this)">I2</span>
                            <span onclick="select(this)">I1</span>
                            <span class="140"></span>
                        </div>
                    </div>
                    <div class="section-block">
                            <span class="49"></span>
                            <span class="48"></span>
                            <span class="47"></span>
                            <span class="46"></span>
                            <span class="45"></span>
                            <span class="44"></span>
                            <span class="43"></span>
                            <span class="42"></span>
                            <span class="41"></span>
                            <span class="40"></span>
                    </div>
                    <div class="section-block">
                    <span></span>
                        <span onclick="select(this)">J8</span>
                        <span onclick="select(this)">J7</span>
                        <span onclick="select(this)">J6</span>
                        <span onclick="select(this)">J5</span>
                        <span onclick="select(this)">J4</span>
                        <span onclick="select(this)">J3</span>
                        <span onclick="select(this)">J2</span>
                        <span onclick="select(this)">J1</span>
                        <span></span>
                    </div>
                </div> <br> <button value="depot" type="submit">Depot</button>
                
                <button value="Submit" id="submit" onclick="JavaScript:return Validator();" >Submit</button>
            </div>
         
        </form>

    </div>
</body>
</html>

<script>

</script>

</html>