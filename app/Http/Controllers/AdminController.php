<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function createUserForm()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'required|string|max:255',
            'position' => 'required|string|max:255',
        ]);

        User::create([
            'title' => $request->title,
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'position' => $request->position,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'utilisateur a été bien crée.');
    }

        public function listUsers()
        {
            $users = User::all();
            return view('admin.users.index', compact('users'));
        }

        public function makeAdmin(Request $request, $id)
        {
            $user = User::findOrFail($id);
            $user->role = 'admin';
            $user->is_superadmin = false; // Assurez-vous que ce n'est pas un superadmin
            $user->save();

            return redirect()->route('admin.users.index')->with('success', 'User is now an admin.');
        }

        public function revokeAdmin(Request $request, $id)
         {
            $user = User::findOrFail($id);
            $user->role = 'user';
            $user->is_superadmin = false;
            $user->save();

            return redirect()->route('admin.users.index')->with('success', 'Admin role has been revoked.');
         }
    
        public function editUserForm($id)
        {
            $user = User::findOrFail($id);
            return view('admin.users.edit', compact('user'));
        }

        public function updateUser(Request $request, $id)
        {
            $user = User::findOrFail($id);
            $request->validate([
                'title' => 'required|string|max:255',
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'phone_number' => 'required|string|max:255',
                'position' => 'required|string|max:255',
            ]);
        
            $user->title = $request->title;
            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->position = $request->position;
            $user->save();

            return redirect()->route('admin.users.index')->with('success', 'Utilisateur modifié avec succé.');
        }

        public function deleteUser($id)
        {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succé.');
        }

        public function adjustSubvention(Request $request, $id)
        {
            $request->validate([
                'subvention' => 'required|string',
            ]);

            $user = User::findOrFail($id);

            // Nettoyer le champ pour enlever le symbole % si présent
            $subvention = str_replace('%', '', $request->input('subvention'));

            // Enregistrer la subvention dans la base de données
            $user->subvention = $subvention;
            $user->save();

            return redirect()->route('admin.users.index')->with('success', 'Subvention ajustée avec succès.');
        }


        public function adjustLivraison(Request $request, $id)
        {
            $user = User::findOrFail($id);
            $user->livraison = $request->input('livraison');
            $user->save();

            return redirect()->back()->with('success', 'Livraison ajustée avec succès.');
        }
}
