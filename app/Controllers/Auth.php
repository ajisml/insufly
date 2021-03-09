<?php namespace App\Controllers;

    use CodeIgniter\Controller;
    use App\Models\globalModel;

    class Auth extends Controller{
        public function __construct()
        {
            $this->model            =   new globalModel();
        }
        public function pSignin()
        {
            if(!$this->validate([
                'username'          =>  'required',
                'password'          =>  'required'
            ])){
                $data               =
                [
                    'success'       =>  false,
                    'data'          =>  'Username / Password Wajib Diisi',
                    'url'           =>  null
                ];
            }else{
                $username           =   $this->request->getPost('username');
                $password           =   $this->request->getPost('password');
                $getLog             =   $this->model->getLog($username,null);
                if($getLog){
                    if(password_verify($password, $getLog['password'])){
                        session()->set([
                            'isLoggedIn'    =>  true,
                            'id'            =>  $getLog['id'],
                            'username'      =>  $getLog['username']
                        ]);
                        $data               =
                        [
                            'success'       =>  true,
                            'data'          =>  'Hore! Kamu Berhasil Masuk',
                            'url'           =>  base_url('home/dashboard')
                        ];
                    }else{
                        $data                =
                        [
                            'success'        => false,
                            'data'           => 'Username / Password Yang Kamu Masukan Salah, Silahkan Coba Lagi',
                            'url'            => null
                        ];
                    }
                }else{
                    $data                    =
                    [
                        'success'            => false,
                        'data'               => 'Username / Password Yang Kamu Masukan Salah, Silahkan Coba Lagi',
                        'url'                => null
                    ];
                }
            }
            return json_encode($data);
        }
        public function pSignout()
        {
            session()->destroy();
            return redirect()->to(base_url('home/signin'));
        }
    }