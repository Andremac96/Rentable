@extends('layouts/main')
@section('title')
  Expenses
@endsection

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        <span class="h3">Property Expenses Logger</span>
      </div>
    </div>

    <div class="row text-center">
      <div class="col-md-12">
        <span class="h5">An aggregated overview of expenses for all properties</span>
      </div>
    </div>
    
    <div class="row">
      <div class="col-md-6">
        <div class="panel-body">
          <canvas id="canvas" height="150" width="300"></canvas>
        </div>
      </div>
    </div>

    <script>
      var url = "{{url('/aggregatedpropertyoverview')}}";
      var Cost = new Array();
      var Category = new Array();
      $(document).ready(function(){
        $.get(url, function(response){
          response.forEach(function(data){
            Cost.push(data.cost);
            Category.push(data.category);
          });
          
          var ctx = document.getElementById("canvas").getContext('2d');
          var myPieChart = new Chart(ctx,{
            type: 'pie',
            
            data : 
            {
              datasets: [{
                data: Cost
              }],
            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels:  Category
            }
          });
        });
      });
  </script>

    @foreach($properties as $property)
      <div class="col-md-4 mt-4">
        <a href="/expenses/property/{{$property->id}}">
          <img class="img-fluid" src="{{$property->photo}}">
        </a>
        <p class="mt-2">{{$property->address .', '. $property->town .', '. $property->county}}</p>
      </div>
    @endforeach
  </div>
@endsection