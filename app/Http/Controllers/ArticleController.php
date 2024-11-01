<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use GuzzleHttp\Client; // Import GuzzleHttp\Client
use App\Enums\CategorieEnum;
use Illuminate\Support\Facades\Storage; 
use Auth;

class ArticleController extends Controller
{
    protected $client;
    protected $apiUrl = 'http://localhost:1064/api/articles'; // Replace with your API URL

    public function __construct()
    {
        $this->client = new Client(); // Initialize Guzzle client
    }

    public function index()
    {
        $response = $this->client->get($this->apiUrl . "/all"); // Use Guzzle to GET articles
        $articles = json_decode($response->getBody(), true);
        return view('back.articles.index', compact('articles'));
    }

    public function index_front()
    {
        $response = $this->client->get($this->apiUrl . "/all"); // Use Guzzle to GET articles
        $articles = json_decode($response->getBody(), true);

        return view('front.articles.index_front', compact('articles'));
    }

    public function create()
    {
        return view('back.articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|min:10',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'categories' => ['required', 'in:'.implode(',', CategorieEnum::getValues())],
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        $data = $request->all();
        //$data['user_id'] = 1; 
        $data['image'] = $imagePath;

        // Use Guzzle to POST the new article
        $response = $this->client->post($this->apiUrl . "/create", [
            'json' => $data,
        ]);

        return redirect()->route('back.articles.index')->with('success', 'Article ajouté avec succès !');
    }

    public function show($id)
    {
        $response = $this->client->get("{$this->apiUrl}/{$id}");
        $article = json_decode($response->getBody(), true);
    
        // Display the article structure
       // dd($article);
    
        return view('back.articles.show', compact('article'));
    }
    
    public function show_front($id)
    {
        $response = $this->client->get("{$this->apiUrl}/{$id}");
        $article = json_decode($response->getBody(), true);
    
        // Display the article structure
       // dd($article);
    
        return view('front.articles.show', compact('article'));
    }
    public function edit($id)
    {
        $response = $this->client->get("{$this->apiUrl}/{$id}");
        $article1 = json_decode($response->getBody(), true);
        
        // Create a new array with the desired attribute names
        $article = [
            'id' => $article1['idArticle'], // Keep original idArticle intact
            'title' => $article1['titleArticle'], // Change titleArticle to title
            'content' => $article1['contentArticle'], // Change contentArticle to content
            'image' => $article1['imageArticle'], // Change imageArticle to images
            'categories' => $article1['categoriesArticle'], // Change categoriesArticle to categories
        ];
        
        // Optionally, you can debug the response if needed
        // dd($article);
        
        return view('back.articles.edit', compact('article'));
    }
    public function update(Request $request, $id)
    {
        // Validate the request inputs
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'categories' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Retrieve the existing article using Guzzle
        $response = $this->client->get("{$this->apiUrl}/{$id}"); 
        $article = json_decode($response->getBody(), true);
    
        // Handle image update
        if ($request->hasFile('image')) {
            // If an image exists, delete the old one from storage
            if (isset($article['imageArticle'])) { // Ensure this matches how the image is stored
                Storage::delete('public/' . $article['imageArticle']);
                
            }
            
            // Store the new image
            $imagePath = $request->file('image')->store('images', 'public');
            $article['imageArticle'] = $imagePath; // Update the image path
        }
      
    
        // Update article properties
        $article['title'] = $request->input('title'); // Ensure the keys match
        $article['content'] = $request->input('content'); 
        $article['categories'] = $request->input('categories'); 
        $article2 = [
            'id' => $article['idArticle'], // Keep original idArticle intact
            'title' => $article['title'], // Change titleArticle to title
            'content' => $article['content'], // Change contentArticle to content
            'image' => $article['imageArticle'], // Change imageArticle to images
            'categories' => $article['categories'], // Change categoriesArticle to categories
        ];
        
    
       //dd($article2);
        // Use Guzzle to PUT the updated article
        $response = $this->client->put("{$this->apiUrl}/update/{$id}", [
            'json' => $article2,
        ]);    
        return redirect()->route('back.articles.index')->with('success', 'Article mis à jour avec succès.');
    }
    
    
    public function destroy($id)
    {
        // Use Guzzle to DELETE the article
        $response = $this->client->delete("{$this->apiUrl}/delete/{$id}");

        return redirect()->route('back.articles.index')->with('success', 'Article supprimé avec succès !');
    }
}
