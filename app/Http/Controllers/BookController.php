<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBook;
use App\Domain\Book;
use App\Usecases\GetCollectionAction;
use Hamcrest\Core\JavaForm;
use http\Env\Response;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(GetCollectionAction $action)
    {
        return response()->json([
            'message' => 'ok',
            'data' => $action()
        ],200,[],JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param StoreBook $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreBook $request)
    {
        $book = Book::create($request->input('title'), $request->input('author'));
        //dd($book);
        return response()->json([
            'message' =>'Book created successfully',
            'data' => $book
        ],201,[], JSON_UNESCAPED_UNICODE);

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function show($id)
    {
        $book = Book::findById($id);
        //dd($book);
        if($book){
            return response()->json([
                'message' =>'ok',
                'gata' => $book
            ],200,[], JSON_UNESCAPED_UNICODE);
        }else{
            return response()->json([
                'massage' => 'Book not found',
            ],404);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $book = Book::findById($id);
        $book->update($request->input('title'), $request->input('author'),$id);
        //dd($book);
        if($book){
            return response()->json([
                'mesage' => 'Book update successfully',
            ],200);
        }else{
            return response()->json([
                'message' =>'Book not found',
            ],404);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $book = Book::where('id',$id)->delete();
        if ($book){
            return response()->json([
                'message' => 'Book deleted successfully',
            ],200);
        }else {
            return response()->json([
                'message' =>'Book not found',
            ],404);
        }
    }
}
