@extends('layouts.dashboard.app')

@section('adminContent')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>products</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">products</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->

      <div class="row">
        <div class="col-md-12">
          <form action="">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                <input type="text" name="search" autofocus placeholder="Search.." class="form-control" value="{{request()->search}}">
                </div>
              </div>
              <div class="col-md-2">
                <select class="form-control"  name="category_id" style="display:inline-block">
                  <option selected disabled>Filter By Category</option>
                  <option></option>
                  @foreach ($categories as $category)
                  <option value="{{$category->id}}" {{ request()->category_id == $category->id ? 'selected' : ''}}>{{$category->name_en}}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4">
                <button class="btn btn-primary" type="submit"><i class="fa fa-search mr-1"></i>Search</button>
                @if (auth()->user()->hasPermission('products-create'))
                <a href="{{route('products.create', app()->getLocale()  )}}"> <button type="button" class="btn btn-primary">Create product</button></a>

                @else
                <a href="#" aria-disabled="true"> <button type="button" class="btn btn-primary">Create product</button></a>

                @endif
              </div>
            </div>
          </form>
        </div>
      </div>



      <div class="card">
        <div class="card-header">


        <h3 class="card-title">products</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body p-0">
          @if($products->count() > 0)
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th>
                          #id
                      </th>
                      <th>
                        Image
                    </th>
                      <th>
                           Arabic Name
                      </th>
                      <th>
                        English Name
                      </th>
                   <th>
                    purchace price
               </th>
               <th>
                 sale price
               </th>
               <th>
                profit %
              </th>
               <th>
                 stock
            </th>
            <th>
              type
            </th>
            <th>
                Download Link
              </th>
                      <th>
                        Created At
                    </th>
                    <th>
                      Updated At
                  </th>
                  <?php if($products !== Null){$product = $products[0];} ?>
                  @if ($product->trashed())
                  <th>
                    Deleted At
                  </th>
                  @endif
                      <th style="" class="">
                        Actions
                      </th>
                  </tr>
              </thead>
              <tbody>
                  <tr>

                      @foreach ($products as $product)
                    <td>
                        {{ $product->id }}
                    </td>
                    <td>

                      <img alt="Avatar" class="table-avatar" src="{{ asset('storage/images/products/' . $product->image) }}">

                  </td>
                    <td>
                        <small>
                            {{ $product->name_ar }}
                        </small>
                    </td>
                    <td>
                      <small>
                          {{ $product->name_en }}
                      </small>
                  </td>
              <td>
                <small>
                    {{ $product->purchase_price }}
                </small>
            </td>
            <td>
              <small>
                  {{ $product->sale_price }}
              </small>
          </td>
          <td>
            <small>
                {{ $product->profit_percent }} %
            </small>
        </td>
          <td>
            <small>
                {{ $product->stock }}
            </small>
        </td>
        <td>
          <small>
              {{ $product->type }}
          </small>
      </td>
      <td>
        <small>

            @if ($product->down_link == '#')
                {{'not available'}}
            @else
            <a href="{{ asset('storage/products/files/' . $product->down_link) }}">Download</a>
            @endif


        </small>
    </td>
                    <td>
                        <small>
                            {{ $product->created_at }}
                        </small>
                    </td>
                    <td>
                      <small>
                          {{ $product->updated_at }}
                      </small>
                  </td>
                  @if ($product->trashed())
                  <td>
                    <small>
                        {{ $product->deleted_at }}
                    </small>
                </td>
                  @endif
                    <td class="project-actions">

                        @if (!$product->trashed())
                        @if (auth()->user()->hasPermission('products-update'))
                        <a class="btn btn-info btn-sm" href="{{route('products.edit' , ['lang'=>app()->getLocale() , 'product'=>$product->id])}}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Edit
                        </a>
                        @else
                        <a class="btn btn-info btn-sm" href="#" aria-disabled="true">
                          <i class="fas fa-pencil-alt">
                          </i>
                          Edit
                      </a>
                      @endif
                        @else
                        @if (auth()->user()->hasPermission('products-restore'))

                        <a class="btn btn-info btn-sm" href="{{route('products.restore' , ['lang'=>app()->getLocale() , 'product'=>$product->id])}}">
                          <i class="fas fa-pencil-alt">
                          </i>
                          Restore
                      </a>
                      @else
                      <a class="btn btn-info btn-sm" href="#" aria-disabled="true">
                        <i class="fas fa-pencil-alt">
                        </i>
                        Restore
                    </a>
                    @endif
                                @endif

                                @if ((auth()->user()->hasPermission('products-delete'))| (auth()->user()->hasPermission('products-trash')))

                                    <form method="POST" action="{{route('products.destroy' , ['lang'=>app()->getLocale() , 'product'=>$product->id])}}" enctype="multipart/form-data" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm delete">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                    @if ($product->trashed())
                                                    {{ __('Delete') }}
                                                    @else
                                                    {{ __('Trash') }}
                                                    @endif
                                                </button>
                                    </form>
                                    @else
                                    <button  class="btn btn-danger btn-sm">
                                      <i class="fas fa-trash">
                                      </i>
                                      @if ($product->trashed())
                                      {{ __('Delete') }}
                                      @else
                                      {{ __('Trash') }}
                                      @endif
                                  </button>
                                  @endif


                    </td>
                </tr>
                      @endforeach


              </tbody>
          </table>

          <div class="row mt-3"> {{ $products->appends(request()->query())->links() }}</div>

          @else <h3 class="pl-2">No products To Show</h3>
          @endif
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->


  @endsection
