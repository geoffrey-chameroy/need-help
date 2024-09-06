import JobCard from "@/components/JobCard";
import OfferCard from "@/components/OfferCard";

async function getJob(id) {
    const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/jobs/${id}`);
    return res.json();
}

export default async function OfferPage({params}) {
    const job = await getJob(params.id);

    return (
        <div>
            <h1>Job :</h1>
            <JobCard
                id={job.id}
                title={job.title}
                description={job.description}
                createdAt={job.createdAt}
            />
            <h2>Offres :</h2>
            <div className="flex flex-wrap justify-left">
                {job.offers.map((offer) => (
                    <OfferCard
                        id={offer.id}
                        jobber={offer.jobber}
                        amount={offer.amount}
                    />
                ))}
            </div>
        </div>
    );
}
