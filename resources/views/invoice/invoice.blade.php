<!DOCTYPE html>

<html>

<head>

  <title>Invoice</title>



<!-- <link href="https://fonts.googleapis.com/css2?family=Assistant&family=Libre+Baskerville&family=Patrick+Hand&display=swap" rel="stylesheet"> -->

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">







<style type="text/css">



/* :root {

  --blue: #0d83dd ;

}

 */







/*global needs*/

 .page-break {

      page-break-after: always;

   }





hr{

  border-top: 3px solid #0d83dd;

  margin-left: 20px;

  margin-right: 30px;

}



hr.dottedGrey{

  border-top: 3px solid grey;

  margin-left: 20px;

  margin-right: 30px;

}





.smallGreyText{

  color: grey;

}



.mediumBlackText{

  color: black;

  font-weight: bold;

}



.largeBlueText{

  color: #0d83dd;

  font-weight: bold;

  font-size: 40px;

}



.clearfix{

  clear: both;

  display: block;

}





/*head container*/

/*1st container*/

.head-container{

  height: 100px;

  background: #0d83dd ;

  color: white;

  font-size: 12px;

}



.head-item-1{

  float: left;

  width: 33.33%;

  line-height: .6px;

  margin-top: 60px;

  margin-left: 20px;

    font-size: 30px;



}



.head-item-2{

  float: left;

  width: 33.33%;

  margin-top: 40px;

  line-height: .4px;

}



.head-item-3{

  float: left;

  width: 33.33%;

  margin-top: 40px;

  line-height: .4px;

}







/*2nd container*/

/*info container*/

.info-container{

  height: 100px;

  color: black;

}

.info-item-1{

  margin-left: 20px;

  /*font-size: 50px;*/

  line-height: .6;

  float: left;

  width: 20%;

  margin-top: 20px;



}

.info-item-2{

  line-height: .6;

  float: left;

  width: 20%;

  margin-top: 20px;

}

.info-item-3{

  line-height: .6;

  text-align: right;

  margin-right: 30px;

  float: right;

  width: 50%;

  margin-top: 20px;

}











/*//3rd tableHeader container*/

.tableHeader-container{

  color: #0d83dd;

  margin-top: 30px;

  font-weight: bold;

}

.tableHeader-item-1{

  margin-left: 20px;

  line-height: .6;

  float: left;

  width: 30%;

}

.tableHeader-item-2{

  line-height: .6;

  text-align: right;

  float: left;

  width: 20%;

}

.tableHeader-item-3{

  line-height: .6;

  float: left;

  text-align: right;

  width: 20%;

}

.tableHeader-item-4{

  line-height: .6;

  text-align: right;

  float: right;

  margin-right: 30px;

  width: 20%;

}





/*//3rd tableBody container*/

.tableBody-container{

  color: #0d83dd;

  margin-top: 30px;

  font-weight: bold;

}

.tableBody-item-1{

  margin-left: 20px;

  line-height: .6;

  float: left;

  width: 30%;

}

.tableBody-item-2{

  line-height: .6;

  text-align: right;

  float: left;

  width: 20%;

}

.tableBody-item-3{

  line-height: .6;

  float: left;

  text-align: right;

  width: 20%;

}

.tableBody-item-4{

  line-height: .6;

  text-align: right;

  float: right;

  margin-right: 30px;

  width: 20%;

}

















/*//summary container*/

.summary-container{

  color: #0d83dd;

  margin-top: 30px;

  font-weight: bold;

}

.summary-item-1{

  margin-left: 20px;

  line-height: .6;

  float: left;

  margin-top: 50px ;

  width: 55%;

}

.summary-item-2{

  line-height: .6;

  text-align: right;

  float: left;

  width: 20%;

}

.summary-item-3{

  color: black;

  line-height: .6;

  float: right;

  text-align: right;

   margin-right: 30px;

  width: 20%;

}











/*thanks container*/

.thanks-container{

margin-top:20px;

  color: black;

  text-align: center;

}

.thanks-item-1{

  text-align: center;

  line-height: .6;

}





</style>



</head>

<body>



  <div>



  <!-- 1st container -->

  <div class=" head-container ">

    <div class="head-item-1">

      Invoice

    </div>

    <div class="head-item-2">
      <p> Email: mahmudhasanauvi@gmail.com  </p>
      <p> Mobile: 01788-989698 </p>
      <p> www.hasancomputers.com </p>
    </div>
    <div class="head-item-3">
      <p> Hasan Computers </p>
      <p> Zila Parishad </p>
      <p> Kurigram Sadar, Kurigram </p>
    </div>

  </div>


<div class="clearfix"></div>



  <!-- 2nd container -->

  <div class=" info-container ">

    <div class="info-item-1">

      <p class="smallGreyText"> Billed To </p>



  @if ($client['name'] == 'Walk In')



    <p class="mediumBlackText"> {{ $address['name']    }} </p>

      <p class="mediumBlackText"> {{ $address['mobile']  }} </p>

      <p class="mediumBlackText"> {{ $address['address'] }} </p>



    @else



    <p class="mediumBlackText"> {{ $client['company_name']    }}  </p>
    <p class="mediumBlackText"> {{ $client['name']    }}  </p>

      <p class="mediumBlackText"> {{ $client['mobile']  }}  </p>

      <p class="mediumBlackText"> {{ $client['address'] }}  </p>



    @endif





    </div>

    <div class="info-item-2">

      <p class="smallGreyText"> Invoice Number </p>

      <p class="mediumBlackText"> HCC-{{ $id }} </p>

      <p class="smallGreyText"> Date Of Issue </p>

      <p class="mediumBlackText"> {{ $date }} </p>

    </div>

    <div class="info-item-3">

      <p class="smallGreyText"> Invoice Total </p>


<p class="largeBlueText"> 



        {{ $total }}
</p>

    </div>

  </div>

  

<div class="clearfix"></div>



  <hr>





  <!-- table header -->

  <div class=" tableHeader-container ">

    <div class="tableHeader-item-1">

      <p> Description </p>

    </div>

    <div class="tableHeader-item-2">

      <p> Unit Cost </p>

    </div>

    <div class="tableHeader-item-3">

      <p> Quantity </p>

    </div>

    <div class="tableHeader-item-4">

      <p> Amount </p>

    </div>

  </div>





<div class="clearfix"></div>



  @foreach ($order_details as $p)

    

  <!-- table body -->

    <div class=" tableBody-container ">

      <div class="tableBody-item-1">

        <p class="mediumBlackText"> {{ $p['products']['name']  }} </p>

        <p class="smallGreyText"> {{ $p['products']['description']  }} </p>

      </div>

      <div class="tableBody-item-2">

        <p class="mediumBlackText"> {{ $p['price']  }} </p>

      </div>

      <div class="tableBody-item-3">

        <p class="mediumBlackText"> {{ $p['quantity']  }} </p>

      </div>

      <div class="tableBody-item-4">

        <p class="mediumBlackText"> {{ $p['quantity'] * $p['price']   }} </p>

      </div>

    </div>





    <div class="clearfix"></div>



  <hr class="dottedGrey">


  @endforeach









  









  <!-- summary container -->

   <div class=" summary-container ">



  <div class="summary-item-1">

      <p class="smallGreyText"> Signature </p>

    </div>

  

   <div class="summary-item-2">

      <p> Subtotal </p>

      <p> Discount </p>

      <p> Total </p>

    </div>



    <div class="summary-item-3">

  <p> {{ $subtotal }} </p>
  <p> {{ $discount }} </p>
  <p> {{ $total }} </p>

    </div>

    

  </div>



  <div class="clearfix"></div>





<!-- 

   <div class=" thanks-container ">

    <div class="thanks-item-1">

      <p>Thank You for being with Hasan Computers</p>

    </div>

  </div> -->



  </div>





</body>

</html>