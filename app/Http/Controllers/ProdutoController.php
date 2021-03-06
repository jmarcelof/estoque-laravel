<?php

namespace estoque\Http\Controllers;

use estoque\Http\Requests\ProdutosRequest;
use estoque\Produto;
use Illuminate\Support\Facades\Request;

class ProdutoController extends Controller {


    /**
     * ProdutoController constructor.
     */
    public function __construct() {
        $this->middleware('auth', ['only' => ['adiciona', 'remove']]);
    }

    public function lista() {
        $produtos = Produto::all();
        return view('produto.listagem')
            ->with('produtos', $produtos);
    }

    public function mostra($id) {
        $produto = Produto::find($id);
        if (empty($produto)) {
            return "Esse produto não existe";
        }
        return view('produto.detalhes')
            ->with('p', $produto);
    }

    public function novo() {
        return view('produto.formulario');
    }

    public function adiciona(ProdutosRequest $request) {
        Produto::create($request->all());
        return redirect()
            ->action('ProdutoController@lista')
            ->withInput(Request::only('nome'));
    }

    public function remove($id) {
        Produto::find($id)->delete();
        return redirect()
            ->action('ProdutoController@lista');
    }

    public function edita($id) {
        return view('produto.edicao')
            ->with('p', Produto::find($id));
    }

    public function salva() {
        Produto::find(Request::get('id'))
            ->fill(Request::all())
            ->save();
        return redirect()
            ->action('ProdutoController@lista');
    }
}
