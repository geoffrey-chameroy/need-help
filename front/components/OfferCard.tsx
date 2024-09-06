export default function offerCard({id, jobber, amount}) {
    return (
        <div className="max-w-sm rounded overflow-hidden shadow-lg bg-white m-4">
            <div className="px-6 py-4">
                <div className="text-gray-700 font-bold text-xl mb-2">{jobber.name}</div>
                <p className="text-gray-700 text-base">{amount} €</p>
            </div>
        </div>
    );
}
