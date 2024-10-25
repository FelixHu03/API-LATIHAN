"use client";
import axios from "axios";
import { useEffect, useState } from "react";

async function getUser() {
    try {
        const res = await axios.get('http://127.0.0.1:8000/api/Pendaftaran');
        const users = res?.data?.data.map(item => item.data); // Ekstraksi data pengguna
        return users;
    } catch (error) {
        console.error('Error fetching user data:', error);
        return [];
    }
}

export default function Page() {
    const [users, setUsers] = useState([]); 
    const [isLoading, setIsLoading] = useState(false); 
    
    useEffect(() => {
        async function fetchData() {
            setIsLoading(true);
            const userData = await getUser();
            setUsers(userData); 
            setIsLoading(false);
        }

        fetchData();
    }, []);
    
    return (
        <div>
            <h1>Data Pengguna</h1>
            {isLoading ? (
                <p>Loading...</p>
            ) : users.length > 0 ? (
                <ul>
                    {users.map((user, index) => (
                        <li key={user.id}>
                            <p><strong>Nama:</strong> {user.nama}</p>
                            <p><strong>Email:</strong> {user.email}</p>
                            <p><strong>Nomor Telepon:</strong> {user.nomor_telepon}</p>
                            <p><strong>Tingkat Sekolah:</strong> {user.tingkat_sekolah}</p>
                        </li>
                    ))}
                </ul>
            ) : (
                <p>No users found.</p>
            )}
        </div>
    );
}
