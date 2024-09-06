'use client'
import Link from 'next/link';
import {useRouter} from 'next/navigation';

export default function JobCard({id, title, description, createdAt}) {
    const router = useRouter();
    createdAt = new Date(createdAt);
    const formattedDate = createdAt.toLocaleDateString('fr-FR', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
    });

    return (
        <div className="max-w-sm rounded overflow-hidden shadow-lg bg-white m-4">
            <Link className="text-gray-600 text-sm" href={`/jobs/${id}`}>
                <div className="px-6 py-4">
                    <div className="font-bold text-xl mb-2">{title}</div>
                    <p className="text-gray-700 text-base">{description}</p>
                    <p className="text-gray-600 text-sm">Publié le {formattedDate}</p>
                </div>
            </Link>
        </div>
    );
}
