import { authentication } from "./authentication.reducer";
// import {
//     users
// } from "./users.reducer";
import { feedMemData } from "./feedMemData.reducer";
import { feedMemShare } from "./feedMemShare.reducer";
import { feedMemLoan } from "./feedMemLoan.reducer";
import { feedMemLoanStatement } from "./feedMemLoanStatement.reducer";
import { feedMemDep } from "./feedMemDep.reducer";
import { feedMemDepStatement } from "./feedMemDepStatement.reducer";
import { feedMemKep } from "./feedMemKep.reducer";
import { feedMemColl } from "./feedMemColl.reducer";
import { feedMemGian } from "./feedMemGian.reducer";
import { feedMemDiv } from "./feedMemDiv.reducer";
import { Mempass } from "./Mempass.reducer";
import { MemRegis } from "./MemRegis.reducer";
import { MemForget } from "./MemForget.reducer";
import { feedMemCrem } from "./feedMemCrem.reducer";
export const memberReducers = {
    authentication,
    // users,
    feedMemData,
    feedMemShare,
    feedMemLoan,
    feedMemLoanStatement,
    feedMemDep,
    feedMemDepStatement,
    feedMemKep,
    feedMemColl,
    feedMemGian,
    feedMemDiv,
    Mempass,
    MemRegis,
    MemForget,
    feedMemCrem
};
