"use client";
import axios from "axios";
import { useEffect, useState } from "react";

async function getUser() {
    try {
        const res = await axios.get('http://127.0.0.1:8000/api/Pendaftaran');
        const users = res?.data?.data.map(item => item.data);
        return users;
    } catch (error) {
        console.error('Error fetching user data:', error);
        return [];
    }
}

const postPendaftaran = async (formData) => {
    try {
        await axios.post('http://127.0.0.1:8000/api/Pendaftaran', {
            nama: formData.nama,
            nomor_telepon: formData.nomorTelepon,
            email: formData.email,
            tingkat_sekolah: formData.tingkatSekolah,
        });
        return { success: true, message: "Data berhasil Dimasukkan" }; 
    } catch (error) {
        console.error("Error during form submission: ", error);
        return {
            success: false, 
            message: "Terjadi Kesalahan Dalam Mengirim Data, Harap Di Cek Kembali!!!"
        };
    }
}
async function deleteUser(id) {
    try {
        await axios.delete(`http://127.0.0.1:8000/api/Pendaftaran/${id}`);
        return { success: true, message: "Data berhasil Dihapus" };
    } catch (error) {
        console.error('Error deleting user:', error);
        return { 
            success: false, 
            message: "Gagal menghapus data. Silakan coba lagi." 
        };
    }
}

export default function Page() {
    const [users, setUsers] = useState([]);
    const [isLoading, setIsLoading] = useState(false);
    const [message, setMessage] = useState("");

    // Fixed formData initialization
    const [formData, setFormData] = useState({
        nama: '',
        email: '',
        nomorTelepon: '',
        tingkatSekolah: ''
    });

    // Added missing handleChange function
    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
    };

    // Added missing fetchData function
    const fetchData = async () => {
        setIsLoading(true);
        const userData = await getUser();
        setUsers(userData);
        setIsLoading(false);
    };

    const handleSubmit = async (e) => {
        e.preventDefault(); 
        const res = await postPendaftaran(formData);
        setMessage(res.message);
        if (res.success) { 
            setFormData({
                nama: '',
                email: '',
                nomorTelepon: '',
                tingkatSekolah: ''
            });
            fetchData();
        }
    };
    const handleDelete = async (id) => {
        const res = await deleteUser(id);
        setMessage(res.message);
        setMessage(res.success ? "success" : "error");
        
        if (res.success) {
            setUsers((prevUsers) => prevUsers.filter((user) => user.id !== id));
            setTimeout(() => {
                setMessage("");
            }, 3000);
        }
    };

    useEffect(() => {
        fetchData();
    }, []);

    return (
        <div className="container mx-auto mt-8 px-4">
            {message && (
                <div className={`p-4 mb-4 rounded ${message.includes("Berhasil")
                    ? "bg-red-100 text-red-700"
                    : "bg-green-100 text-green-700"
                    }`}>
                    {message}
                </div>
            )}

            {/* Table Section */}
            {isLoading ? (
                <p className="text-center">LOADING ...</p>
            ) : (
                <div className="overflow-x-auto">
                    <table className="w-full border-collapse bg-black shadow-md rounded-lg">
                        <thead>
                            <tr>
                                <th className="border p-3 bg-black">Id</th>
                                <th className="border p-3 bg-black">Nama</th>
                                <th className="border p-3 bg-black">Email</th>
                                <th className="border p-3 bg-black">Nomor Telepon</th>
                                <th className="border p-3 bg-black">Tingkat Sekolah</th>
                                <th className="border p-3 bg-black">submission</th>
                            </tr>
                        </thead>
                        <tbody>
                            {users.map((user, index) => (
                                <tr key={index}>
                                    <td className="border p-3">{user.id}</td>
                                    <td className="border p-3">{user.nama}</td>
                                    <td className="border p-3">{user.email}</td>
                                    <td className="border p-3">{user.nomor_telepon}</td>
                                    <td className="border p-3">{user.tingkat_sekolah}</td>
                                    <td className="border p-3"><button
                                        onClick={() => handleDelete(user.id)}
                                        className="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-md"
                                    >
                                        Delete
                                    </button></td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            )}
            <br />
            <h1 className="text-2xl font-bold mb-6">Data Pendaftaran</h1>

            {/* Form Section */}
            <div className="mb-8 p-6 bg-black rounded-lg shadow-md">
                <h2 className="text-xl font-semibold mb-4">Form Pendaftaran</h2>
                {message && (
                    <div className={`p-4 mb-4 rounded ${message.includes("Berhasil")
                        ? "bg-red-100 text-red-700"
                        : "bg-green-100 text-green-700"
                        }`}>
                        {message}
                    </div>
                )}
                <form onSubmit={handleSubmit} className="space-y-4">
                    <div>
                        <label className="block text-white mb-2">Nama:</label>
                        <input
                            type="text"
                            name="nama"
                            value={formData.nama}
                            onChange={handleChange}
                            className="w-full p-2 border rounded text-black"
                            required
                        />
                    </div>
                    <div>
                        <label className="block text-white mb-2">Email:</label>
                        <input
                            type="email"
                            name="email"
                            value={formData.email}
                            onChange={handleChange}
                            className="w-full p-2 border rounded text-black "
                            required
                        />
                    </div>
                    <div>
                        <label className="block text-white mb-2">Nomor Telepon:</label>
                        <input
                            type="tel"
                            name="nomorTelepon"
                            value={formData.nomorTelepon}
                            onChange={handleChange}
                            className="w-full p-2 border rounded text-black"
                            required
                        />
                    </div>
                    <div>
                        <label className="block text-white mb-2">Tingkat Sekolah:</label>
                        <select
                            name="tingkatSekolah"
                            value={formData.tingkatSekolah}
                            onChange={handleChange}
                            className="w-full p-2 border rounded text-black"
                            required
                        >
                            <option value="">Pilih Tingkat Sekolah</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="SMA">SMA</option>
                            <option value="Universitas">Universitas</option>
                        </select>
                    </div>
                    <button
                        type="submit"
                        className="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                    >
                        Submit
                    </button>
                </form>
            </div>
        </div>
    );
}