import React from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/react";

function ViewLaws({ laws }) {

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Laws
                </h2>
            }
        >
            <Head title="Laws" />

            <div className="max-w-screen-md mt-3 mx-auto px-4 text-black card shadow-sm">
                {/* <button className="btn">Add Law</button> */}
                {laws.map((law) => (
                    <div className="bg-white/95 card shadow-sm mb-2">
                        <Link href={`/laws/${law.id}/chapters`} className="p-3" key={law.id}>
                            <p className="font-bold text-xl">{law.title}</p>
                            <p className="text-sm">{law.description}</p>
                        </Link>
                    </div>
                ))}{" "}
            </div>
        </AuthenticatedLayout>
    );
}

export default ViewLaws;
